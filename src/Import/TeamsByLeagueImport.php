<?php


namespace App\Import;


use App\Command\ImportCommand;
use App\Entity\League;
use App\Entity\Team;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class TeamsByLeagueImport extends ImportFather implements ImporterInterface
{

    const type = 'teams-by-league';

    public function supports($type)
    {
        return self::type === $type;
    }

    public function import()
    {
        $leagues = $this->entityManager->getRepository(League::class)->findAll();

        $progressBar = new ProgressBar(new ConsoleOutput(),count($leagues));

        /**
         * @var $league League
         */
        foreach ($leagues as $league){
            $response = $this->client->request('GET',sprintf(ImportCommand::feeds[self::type], rawurlencode($league->getName())));

            $teams = $response->toArray();

            if(empty($teams['teams'])) continue;

            $teams = $teams['teams'];

            foreach ($teams as $team){

                $teamEntity = $this->entityManager->getRepository(Team::class)->findOneBy(['id' => $team['idTeam']]);


                if(!$teamEntity) {
                    $teamEntity = new Team();
                    $teamEntity->setId($team['idTeam']);
                    $this->entityManager->persist($teamEntity);

                }

                $teamEntity->setName($team['strTeam']);
                $teamEntity->setLeague($league);
                $teamEntity->setFormedYear((int)$team['intFormedYear']);
                $teamEntity->setYoutube($team['strYoutube']);
                $teamEntity->setWebsite($team['strWebsite']);
                $teamEntity->setFacebook($team['strFacebook']);
                $teamEntity->setTwitter($team['strTwitter']);
                $teamEntity->setDescription($team['strDescriptionEN']);
                $teamEntity->setStadium($team['strStadium']);
                $teamEntity->setStadiumCapacity((int) $team['intStadiumCapacity']);
                $teamEntity->setStadiumDescription($team['strStadiumDescription']);
                $teamEntity->setStadiumLocation($team['strStadiumLocation']);
                $this->entityManager->flush();

            }
            $progressBar->advance();
        }

    }
}
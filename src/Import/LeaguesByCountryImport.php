<?php


namespace App\Import;


use App\Command\ImportCommand;
use App\Entity\Country;
use App\Entity\League;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class LeaguesByCountryImport extends ImportFather implements ImporterInterface
{

    const type = 'leagues-by-country';

    public function supports($type)
    {
        return self::type === $type;
    }

    public function import()
    {
        $countries = $this->entityManager->getRepository(Country::class)->findAll();
        $progressBar = new ProgressBar(new ConsoleOutput(),count($countries));

        /**
         * @var $country Country
         */
        foreach ($countries as $country){
            $response = $this->client->request('GET',sprintf(ImportCommand::feeds[self::type],$country->getName()));
            $leagues = $response->toArray();
            if(empty($leagues['countrys'])) continue;

            foreach ($leagues['countrys'] as $league){
                if(empty($league)) continue;

                /**
                 * @var $leagueEntity League
                 */
                $leagueEntity = $this->entityManager->getRepository(League::class)->findOneBy(['id' => $league['idLeague']]);
                if(!$leagueEntity) continue;

                $leagueEntity->setDescription($league['strDescriptionEN']);
                $leagueEntity->setFacebook($league['strFacebook']);
                $leagueEntity->setTwitter($league['strTwitter']);
                $leagueEntity->setYoutube($league['strYoutube']);
                $leagueEntity->setFormedYear((int)$league['intFormedYear']);
                $leagueEntity->setBadgeImage(!empty($league['strBadge'])?$this->imageUpload->uploadImage($league['strBadge'], League::imageDir):null);
                $leagueEntity->setLogoImage(!empty($league['strLogo'])?$this->imageUpload->uploadImage($league['strLogo'], League::imageDir):null);
                $leagueEntity->setBannerImage(!empty($league['strBanner'])?$this->imageUpload->uploadImage($league['strBanner'], League::imageDir):null);
                $leagueEntity->setTrophyImage(!empty($league['strTrophy'])?$this->imageUpload->uploadImage($league['strTrophy'], League::imageDir):null);

                $leagueEntity->setCountry($country);
                $country->addLeague($leagueEntity);
            }
            $progressBar->advance();
        }



        $this->entityManager->flush();
    }
}
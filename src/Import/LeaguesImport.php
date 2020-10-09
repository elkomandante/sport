<?php


namespace App\Import;


use App\Command\ImportCommand;
use App\Entity\League;
use App\Entity\Sport;
use App\Exception\ImportException;

class LeaguesImport extends ImportFather implements ImporterInterface
{

    const type = 'leagues';

    public function supports($type)
    {
        return self::type === $type;
    }

    public function import()
    {
        $response = $this->client->request('GET',ImportCommand::feeds[self::type]);
        if($response->getStatusCode() !== 200) throw new ImportException('test');

        $leagues = $response->toArray();

        foreach ($leagues['leagues'] as $league){
            $sportEntity = $this->getEntityManager()->getRepository(Sport::class)->findOneBy([ 'name' => $league['strSport'] ]);
            if(!$sportEntity) continue;

            $leagueEntity = $this->getEntityManager()->getRepository(League::class)->findOneBy(['id' => $league['idLeague']]);

            if(!$leagueEntity){
                $leagueEntity = new League();
                $leagueEntity->setId($league['idLeague']);
                $leagueEntity->setName($league['strLeague']);
                $this->getEntityManager()->persist($leagueEntity);
            }

            $leagueEntity->setSport($sportEntity);
            $sportEntity->addLeague($leagueEntity);
        }

        $this->getEntityManager()->flush();

    }
}
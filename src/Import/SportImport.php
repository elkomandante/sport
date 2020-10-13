<?php


namespace App\Import;


use App\Command\ImportCommand;
use App\Entity\Sport;
use App\Exception\ImportException;

class SportImport extends ImportFather implements ImporterInterface
{

    const type = 'sport';

    public function supports($type)
    {
        return self::type === $type;
    }

    public function import()
    {

        $response = $this->client->request('GET',ImportCommand::feeds[self::type]);

        if($response->getStatusCode() !== 200){
            throw new ImportException('Import Error occurred! Import type is '.self::type);
        }

        $sports = $response->toArray();

        foreach ($sports['sports'] as $sport){
            $sportEntity = $this->getEntityManager()->getRepository(Sport::class)->findOneBy(['id' => $sport['idSport']]);

            if(!$sportEntity) {
                $sportEntity = new Sport();
                $sportEntity->setId($sport['idSport']);
                $this->getEntityManager()->persist($sportEntity);
            }
            echo $sport['strSport']."\n";
            $sportEntity->setName($sport['strSport']);
            $sportEntity->setDescription($sport['strSportDescription']);
            $sportEntity->setThumbnailImage($this->imageUpload->uploadImage($sport['strSportThumb'],Sport::imageDir));
            $sportEntity->setThumbnailGreenImage($this->imageUpload->uploadImage($sport['strSportThumbGreen'],Sport::imageDir));

        }

        $this->getEntityManager()->flush();

        die();

    }
}
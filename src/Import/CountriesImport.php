<?php


namespace App\Import;


use App\Command\ImportCommand;
use App\Entity\Country;

class CountriesImport extends ImportFather implements ImporterInterface
{

    const type = 'countries';

    public function supports($type)
    {
        return self::type === $type;
    }

    public function import()
    {
        $response = $this->client->request('GET',ImportCommand::feeds[self::type]);

        $countries = $response->toArray();

        foreach ($countries['countries'] as $country){
            $countryEntity = $this->getEntityManager()->getRepository(Country::class)->findOneBy(['name' => $country['name_en']]);
            if(!$countryEntity){
                $countryEntity = new Country();
                $this->entityManager->persist($countryEntity);
            }

            $countryEntity->setName($country['name_en']);
        }

        $this->entityManager->flush();
    }
}
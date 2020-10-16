<?php


namespace App\ApiService\Sport;


use App\Repository\SportRepository;

class SportService
{
    /**
     * @var SportRepository
     */
    private $sportRepository;

    public function __construct(SportRepository $sportRepository)
    {

        $this->sportRepository = $sportRepository;
    }


    public function getAllSports()
    {
        return $this->sportRepository->findAll();
    }
}
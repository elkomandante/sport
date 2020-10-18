<?php


namespace App\ApiService\League;


use App\Repository\LeagueRepository;

class LeagueService
{
    /**
     * @var LeagueRepository
     */
    private $leagueRepository;

    public function __construct(LeagueRepository $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    public function getLeagueById($leagueId)
    {
        return $this->leagueRepository->find($leagueId);
    }
}
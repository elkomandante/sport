<?php


namespace App\Repository;


interface LeagueRepositoryInterface
{
    public function getLeaguesBySport($sportId);
}
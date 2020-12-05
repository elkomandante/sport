<?php


namespace App\Repository;


interface SportRepositoryInterface
{
    public function saveSport($sport);
    public function deleteSport($sport);
}
<?php


namespace App\Import;


interface ImporterInterface
{
    public function supports($type);
    public function import();
}
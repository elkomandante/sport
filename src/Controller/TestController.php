<?php

namespace App\Controller;

use App\Exception\ImportException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {

        throw new ImportException('zika');


        return new Response('pera');
    }
}

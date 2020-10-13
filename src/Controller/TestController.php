<?php

namespace App\Controller;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(EntityManagerInterface $entityManager)
    {

      $country = $entityManager->getRepository(Country::class)->findOneBy(['name'=>'England']);
      foreach ($country->getLeagues() as $league){
          echo $league->getName()."<br>";
      }


        return new Response('pera');
    }
}

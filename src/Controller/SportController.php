<?php

namespace App\Controller;

use App\ApiService\Sport\SportService;
use App\Entity\Sport;
use App\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class SportController extends AbstractController
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var SportService
     */
    private $sportService;


    public function __construct(ApiResponse $apiResponse, SportService $sportService)
    {
        $this->apiResponse = $apiResponse;
        $this->sportService = $sportService;
    }

    /**
     * @Route("/sports", name="sport_list")
     */
    public function sportList()
    {
        $sports = $this->sportService->getAllSports();
        return $this->apiResponse->generateResponse($sports,[AbstractNormalizer::GROUPS => 'sport:list']);
    }

    /**
     * @Route ("/sports/{id}", name="sport_single")
     */
    public function sportSingle(Sport $sport)
    {
        return $this->apiResponse->generateResponse($sport,[AbstractNormalizer::GROUPS => ['sport:single']]);
    }
}

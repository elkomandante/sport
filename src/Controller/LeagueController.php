<?php

namespace App\Controller;

use App\ApiService\League\LeagueService;
use App\Entity\League;
use App\Response\ApiResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class LeagueController extends AbstractController
{

    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var LeagueService
     */
    private $leagueService;

    public function __construct(ApiResponse $apiResponse, LeagueService $leagueService)
    {
        $this->apiResponse = $apiResponse;
        $this->leagueService = $leagueService;
    }

    /**
     * @Route("/leagues/{id}", name="league_single")
     * @ParamConverter("league", class="App\Entity\League")
     * @param League $league
     * @return JsonResponse
     */
    public function getSingleLeague(League $league)
    {
        return $this->apiResponse->generateResponse([$league],[AbstractNormalizer::GROUPS => ['league:single']]);
    }
}

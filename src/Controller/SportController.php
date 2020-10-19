<?php

namespace App\Controller;

use App\ApiService\Sport\SportService;
use App\Entity\Sport;
use App\Form\Type\SportType;
use App\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
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
    /**
     * @var RequestStack
     */
    private $requestStack;


    public function __construct(ApiResponse $apiResponse, SportService $sportService, RequestStack $requestStack)
    {
        $this->apiResponse = $apiResponse;
        $this->sportService = $sportService;
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/sports", name="sport_list", methods={"GET"})
     */
    public function sportList()
    {
        $sports = $this->sportService->getAllSports();
        return $this->apiResponse->generateResponse($sports,[AbstractNormalizer::GROUPS => 'sport:list']);
    }

    /**
     * @Route ("/sports/{id}", name="sport_single", methods={"GET"})
     * @param Sport $sport
     * @return JsonResponse
     */
    public function sportSingle(Sport $sport)
    {
        return $this->apiResponse->generateResponse([$sport],[AbstractNormalizer::GROUPS => ['sport:single']]);
    }


    /**
     * @Route("/sports/{id}/leagues")
     * @param $id
     * @return JsonResponse
     */
    public function getLeaguesBySport($id)
    {
        $leagues = $this->sportService->getLeaguesBySport($id);
        return $this->apiResponse->generateResponse($leagues,[AbstractNormalizer::GROUPS => ['league:list']]);
    }

    /**
     * @Route ("/sports",name="sport_create",methods={"POST"})
     */
    public function createSport()
    {
        $postData = $this->requestStack->getCurrentRequest()->getContent();
        $sport = new Sport();
        $form = $this->createForm(SportType::class,$sport);
        $form->submit(json_decode($postData,true));

        $sport = $this->sportService->savePost($sport);

        return $this->apiResponse->generateResponse([$sport],[AbstractNormalizer::GROUPS => ["sport:single"]]);
    }

    /**
     * @Route(path="/sports/{id}", name="sport_delete", methods={"DELETE"})
     * @param Sport $sport
     * @return JsonResponse
     */
    public function deleteSport(Sport $sport)
    {
        $this->sportService->deleteSport($sport);
        return new JsonResponse(null,200);
    }

    /**
     * @Route(path="/sports/{id}", name="sport_update", methods={"PUT"})
     * @param Sport $sport
     * @return JsonResponse
     */
    public function updateSport(Sport $sport)
    {
        $data = $this->requestStack->getCurrentRequest()->getContent();
        $form = $this->createForm(SportType::class,$sport);
        $form->submit(json_decode($data,true));

        $this->sportService->updateSport($sport);

        return $this->apiResponse->generateResponse([$sport],[AbstractNormalizer::GROUPS => ['sport:single']]);

    }


}

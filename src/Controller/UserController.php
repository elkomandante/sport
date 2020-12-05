<?php

namespace App\Controller;

use App\ApiService\User\UserService;
use App\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{

    const singleRoute = 'user_single';

    private $userService;

    private $apiResponse;

    public function __construct(UserService $userService,ApiResponse $apiResponse)
    {
        $this->userService = $userService;
        $this->apiResponse = $apiResponse;
    }

    /**
     * @Route("/api/users", name="user_list")
     */
    public function userList()
    {
        $users = $this->userService->getAllUsers();
        return $this->apiResponse->generateResponse($users,[AbstractNormalizer::GROUPS => 'user:list']);
    }

    /**
     * @Route (path="/api/users/{id}", name="user_single")
     * @param $id
     * @return JsonResponse
     */
    public function userSingle($id)
    {
        $user = $this->userService->getUserById($id);
        return $this->apiResponse->generateResponse([$user],[AbstractNormalizer::GROUPS => 'user:single']);
    }




}

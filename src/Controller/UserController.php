<?php

namespace App\Controller;

use App\ApiService\User\UserService;
use App\Entity\User;
use App\Form\UserType;
use App\Response\ApiResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
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
     * @Route("/api/users", name="user_list", methods={"GET"})
     */
    public function userList()
    {
        $users = $this->userService->getAllUsers();
        return $this->apiResponse->generateResponse($users,[AbstractNormalizer::GROUPS => 'user:list']);
    }

    /**
     * @Route (path="/api/users/{id}", name="user_single", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function userSingle($id)
    {
        $user = $this->userService->getUserById($id);
        return $this->apiResponse->generateResponse([$user],[AbstractNormalizer::GROUPS => 'user:single']);
    }


    /**
     * @Route("/api/users/{id}", methods={"PATCH"})
     */

    public function userUpdate(User $user, RequestStack $requestStack)
    {
        
        $data = $requestStack->getMasterRequest()->getContent();

        $form = $this->createForm(UserType::class, $user);
        $form->submit(json_decode($data,1),false);

        $this->userService->updateUser($user);

        return $this->apiResponse->generateResponse([$user],[AbstractNormalizer::GROUPS => 'user:single']);
    }





}

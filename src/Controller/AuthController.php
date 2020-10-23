<?php

namespace App\Controller;

use App\ApiService\Auth\AuthService;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AuthController extends AbstractController
{

    /**
     * @Route("/auth/register", name="register", methods={"POST"})
     * @param RequestStack $requestStack
     * @param UserPasswordEncoderInterface $encoder
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function register(RequestStack $requestStack,UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, AuthService $authService)
    {
        $data = $requestStack->getCurrentRequest()->getContent();
        /*** @var $user User */
        $user = $serializer->deserialize($data,User::class,'json');
        $user->setPassword($encoder->encodePassword($user,$user->getPassword()));
        $user->setRoles(["ROLE_USER"]);
        $authService->saveUser($user);

        return new JsonResponse(['User Successfully Created']);
    }
}

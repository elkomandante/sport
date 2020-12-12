<?php


namespace App\ApiService\User;


use App\ApiService\ApiServiceParent;
use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class UserService extends ApiServiceParent implements ServiceSubscriberInterface
{

    private $userRepository;

    private $locator;

    public function __construct(UserRepositoryInterface $userRepository, ContainerInterface $locator)
    {
        $this->userRepository = $userRepository;
        $this->locator = $locator;
    }

    public function getAllUsers()
    {
        return $this->userRepository->findAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function updateUser(User $user)
    {
        $this->validate($this->locator->get(ValidatorInterface::class),$user);
        $this->userRepository->flush();
    }


    public static function getSubscribedServices()
    {
        return [
            ValidatorInterface::class => ValidatorInterface::class
        ];
    }
}
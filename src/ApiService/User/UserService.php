<?php


namespace App\ApiService\User;


use App\Repository\UserRepositoryInterface;

class UserService
{

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->findAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

}
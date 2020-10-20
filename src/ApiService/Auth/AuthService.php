<?php


namespace App\ApiService\Auth;


use App\ApiService\ApiServiceParent;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthService extends ApiServiceParent
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserRepository $userRepository,ValidatorInterface $validator, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function saveUser(User $user)
    {
        $this->validate($this->validator,$user);
        $this->userRepository->saveUser($user);
    }


}
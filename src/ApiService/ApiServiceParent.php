<?php


namespace App\ApiService;


use App\Exception\ViolationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiServiceParent
{
    public function validate(ValidatorInterface $validator, $entity)
    {
        $violations = $validator->validate($entity);
        if(count($violations) !== 0) throw new ViolationException($violations);
    }
}
<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationException extends DomainException
{
    public function __construct(ConstraintViolationListInterface $violations)
    {
        $errors = [];
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }
        parent::__construct($errors);
    }
}

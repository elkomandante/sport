<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UserRoleConstraintValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UserRoleConstraint) {
            throw new UnexpectedTypeException($constraint, UserRoleConstraint::class);
        }

        dd($constraint);

    }

}
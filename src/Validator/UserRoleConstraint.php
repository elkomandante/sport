<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class UserRoleConstraint extends Constraint
{
    public $message = "You dont have appropriate role to change this field";

    public $role;

    public function getRequiredOptions()
    {
        return [
            'role'
        ];
    }
}
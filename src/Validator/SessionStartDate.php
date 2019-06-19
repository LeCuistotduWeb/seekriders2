<?php

namespace App\Validator;
use Symfony\Component\Validator\Constraint;
/**
 * Class SessionStartDate
 * @Annotation
 */
class SessionStartDate extends Constraint
{
    public $message = "La date doit être superieur ou égale à la date du jour.";
}
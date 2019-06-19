<?php
namespace App\Validator;

use App\Service\SessionService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
class SessionStartDateValidator extends ConstraintValidator
{
    protected $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public function validate($value, Constraint $constraint){

        if(!$this->sessionService->startDateIsValid($value)){
            $this->context->buildViolation($constraint->message)
            ->addViolation();
        }
    }
}
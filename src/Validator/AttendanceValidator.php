<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AttendanceValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {


        if (null === $value || '' === $value) {
            return;
        }

        
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}

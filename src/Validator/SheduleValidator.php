<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;


#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class ScheduleValidator extends Constraint
{
    public string $message = 'The schedule value "{{ value }}" is not valid.';
}

class ScheduleValidatorValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ScheduleValidator) {
            throw new UnexpectedTypeException($constraint, ScheduleValidator::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!preg_match('/^(\d{1,2}):(\d{2})-\d{1,2}:\d{2}$/', $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}

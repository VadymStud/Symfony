<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;

class ExamValidator
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, minMessage: 'Exam name must be at least {{ limit }} characters long')]
    public string $name;
    
    #[Assert\NotNull]
    public Instructor $instuctor;
}

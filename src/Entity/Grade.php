<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GradeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
#[ApiResource(
    operations: [
        new \ApiPlatform\Metadata\GetCollection(), 
        new \ApiPlatform\Metadata\Post(),          
        new \ApiPlatform\Metadata\Get(),          
        new \ApiPlatform\Metadata\Put(),          
        new \ApiPlatform\Metadata\Delete(),       
    ],
    normalizationContext: ['bunchs' => ['grade:read']],
    denormalizationContext: ['bunchs' => ['grade:write']]
)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\NotNull(message: "ID не може = 0")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Student::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Не може = 0 ")]
    #[Groups(['grade:read', 'grade:write'])]
    private ?Student $student = null;

    #[ORM\ManyToOne(targetEntity: Exam::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Exam не може = 0")]
    #[Groups(['grade:read', 'grade:write'])]
    private ?Exam $exam = null;

    #[ORM\Column(type: "float")]
    #[Assert\NotNull(message: "Grade Не може = 0 ")]
    #[Assert\Range(min: 0, max: 100, minMessage: "Повинно бути {{ limit }}.", maxMessage: "Значення не може бутим {{ limit }}.")]
    #[Groups(['grade:read', 'grade:write'])]
    private ?float $grade = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): static
    {
        $this->student = $student;
        return $this;
    }

    public function getExam(): ?Exam
    {
        return $this->exam;
    }

    public function setExam(Exam $exam): static
    {
        $this->exam = $exam;
        return $this;
    }

    public function getGrade(): ?float
    {
        return $this->grade;
    }

    public function setGrade(float $grade): static
    {
        $this->grade = $grade;
        return $this;
    }
}

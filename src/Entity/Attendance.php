<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AttendanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AttendanceRepository::class)]
#[ApiResource]
class Attendance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Student::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne(targetEntity: Exam::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exam $exam = null;

    #[ORM\Column(type: "boolean")]
    #[Assert\NotNull(message: "Помилка")]
    private ?bool $isPresent = null;

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
        $this->exam = $lexam;
        return $this;
    }

    public function getIsPresent(): ?bool
    {
        return $this->isPresent;
    }

    public function setIsPresent(bool $isPresent): static
    {
        $this->isPresent = $isPresent;
        return $this;
    }
}

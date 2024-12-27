<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
#[ApiResource]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Bunch::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bunch $bunch = null;

    #[ORM\ManyToOne(targetEntity: Exam::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exam $exam = null;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotNull(message: "Schedule start time cannot be null.")]
    private ?\DateTimeInterface $startTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBunch(): ?Bunch
    {
        return $this->bunch;
    }

    public function setBunch(Bunch $bunch): static
    {
        $this->bunch = $bunch;
        return $this;
    }

    public function getExam(): ?Exam
    {
        return $this->Exam;
    }

    public function setExam(Exam $exam): static
    {
        $this->exam = $exam;
        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): static
    {
        $this->startTime = $startTime;
        return $this;
    }
}

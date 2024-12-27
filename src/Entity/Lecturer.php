<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LecturerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: LecturerRepository::class)]
#[ApiResource(
    normalizationContext: ['bunch' => ['lecturer:read']],
    denormalizationContext: ['bunch' => ['lecturer:write']],
)]
class Lecturer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['lecturer:read'])]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['lecturer:read', 'lecturer:write'])]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Groups(['lecturer:read', 'lecturer:write'])]
    private ?string $relationship = null; 

    #[ORM\ManyToMany(targetEntity: Student::class, mappedBy: 'lecturer')]
    #[Groups(['lecturer:read', 'lecturer:write'])]
    private Collection $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    public function setRelationship(string $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addLecturer($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->students->removeElement($student)) {
            $student->removeLecturer($this);
        }

        return $this;
    }
}

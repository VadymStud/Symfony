<?php

namespace App\Service;

use App\Entity\Instructor;
use App\Repository\InstructorRepository;
use Doctrine\ORM\EntityManagerInterface;

class InstructorService
{
    private InstructorRepository $instructorRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(InstructorRepository $instructorRepository, EntityManagerInterface $entityManager)
    {
        $this->instructorRepository = $instructorRepository;
        $this->entityManager = $entityManager;
    }

    public function createInstructor(array $data): Instructor
    {
        $instructor = new Instructor();
        $instructor->setSubject($data['subject']);
        $instructor->setExperienceYears($data['experience_years']);
        $instructor->setUser($data['user']);  
        
        $this->entityManager->persist($instructor);
        $this->entityManager->flush();

        return $instructor;
    }

    public function updateInstructor(int $id, array $data): Instructor
    {
        $instructor = $this->instructorRepository->find($id);
        if (!$instructor) {
            throw new \Exception('Instructor not found');
        }

        $instructor->setSubject($data['subject']);
        $instructor->setExperienceYears($data['experience_years']);
        $instructor->setUser($data['user']);  

        $this->entityManager->flush();

        return $instructor;
    }

    public function deleteInstructor(int $id): void
    {
        $instructor = $this->instructorRepository->find($id);
        if (!$instructor) {
            throw new \Exception('Instructor not found');
        }

        $this->entityManager->remove($instructor);
        $this->entityManager->flush();
    }
}

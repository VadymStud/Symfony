<?php

namespace App\Service;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;

class StudentService
{
    private StudentRepository $studentRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(StudentRepository $studentRepository, EntityManagerInterface $entityManager)
    {
        $this->studentRepository = $studentRepository;
        $this->entityManager = $entityManager;
    }

    public function createStudent(array $data): Student
    {
        $student = new Student();
        $student->setName($data['name']);
        $student->setEmail($data['email']);
        
        $this->entityManager->persist($student);
        $this->entityManager->flush();

        return $student;
    }

}

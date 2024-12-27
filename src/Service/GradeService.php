<?php

namespace App\Service;

use App\Entity\Grade;
use App\Repository\GradeRepository;
use Doctrine\ORM\EntityManagerInterface;

class GradeService
{
    private GradeRepository $gradeRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(GradeRepository $gradeRepository, EntityManagerInterface $entityManager)
    {
        $this->gradeRepository = $gradeRepository;
        $this->entityManager = $entityManager;
    }

    public function createGrade(array $data): Grade
    {
        $grade = new Grade();
        $grade->setGrade($data['grade']);
        $grade->setStudent($data['student']);
        $grade->setSubject($data['subject']);
        
        $this->entityManager->persist($grade);
        $this->entityManager->flush();

        return $grade;
    }

    public function updateGrade(int $id, array $data): Grade
    {
        $grade = $this->gradeRepository->find($id);
        if (!$grade) {
            throw new \Exception('Grade not found');
        }

        $grade->setGrade($data['grade']);
        $grade->setStudent($data['student']);
        $grade->setSubject($data['subject']);

        $this->entityManager->flush();

        return $grade;
    }

    public function deleteGrade(int $id): void
    {
        $grade = $this->gradeRepository->find($id);
        if (!$grade) {
            throw new \Exception('Grade not found');
        }

        $this->entityManager->remove($grade);
        $this->entityManager->flush();
    }
}

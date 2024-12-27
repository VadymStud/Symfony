<?php

namespace App\Service;

use App\Entity\Exam;
use App\Entity\Instructor;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;

class ExamService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createExam(string $name, Instructor $instructor, array $students, ?string $schedule): Exam
    {
        $exam = new Exam();
        $exam->setName($name);
        $exam->setInstructor($instructor);
        $exam->setSchedule($schedule);

        foreach ($students as $student) {
            if ($student instanceof Student) {
                $exam->addStudent($student);
            }
        }

        $this->entityManager->persist($exam);
        $this->entityManager->flush();

        return $exam;
    }

    public function updateExam(Exam $exam, ?string $name, ?Instructor $instructor, array $students, ?string $schedule): Exam
    {
        if ($name !== null) {
            $exam->setName($name);
        }

        if ($instructor !== null) {
            $exam->setInstructor($instructor);
        }

        if ($schedule !== null) {
            $exam->setSchedule($schedule);
        }

        $exam->getStudents()->clear();
        foreach ($students as $student) {
            if ($student instanceof Student) {
                $exam->addStudent($student);
            }
        }

        $this->entityManager->flush();

        return $exam;
    }

    public function deleteExam(Exam $exam): void
    {
        $this->entityManager->remove($exam);
        $this->entityManager->flush();
    }
}

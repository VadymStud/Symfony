<?php

namespace App\Service;

use App\Entity\Attendance;
use App\Entity\Exam;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;

class AttendanceService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function createAttendance(Student $student, Exam $exam, bool $isPresent, ?\DateTime $date = null): Attendance
    {
        $attendance = new Attendance();
        $attendance->setStudent($student);
        $attendance->setExam($exam);
        $attendance->setIsPresent($isPresent);
        $attendance->setDate($date ?? new \DateTime());

        $this->entityManager->persist($attendance);
        $this->entityManager->flush();

        return $attendance;
    }


    public function updateAttendance(Attendance $attendance, bool $isPresent, ?\DateTime $date = null): Attendance
    {
        $attendance->setIsPresent($isPresent);
        $attendance->setDate($date ?? new \DateTime());

        $this->entityManager->flush();

        return $attendance;
    }


    public function deleteAttendance(Attendance $attendance): void
    {
        $this->entityManager->remove($attendance);
        $this->entityManager->flush();
    }

    /**
     * Повертає список відвідуваня.
     *
     * @return Attendance[]
     */
    public function getAttendanceByStudent(Student $student): array
    {
        return $this->entityManager
            ->getRepository(Attendance::class)
            ->findBy(['student' => $student]);
    }

    /**
     * Повертає список явки студента на екзамені.
     *
     * @return Attendance[]
     */
    public function getAttendanceByExam(Exam $exam): array
    {
        return $this->entityManager
            ->getRepository(Attendance::class)
            ->findBy(['exam' => $exam]);
    }
}

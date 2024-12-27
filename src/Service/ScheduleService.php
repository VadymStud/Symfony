<?php

namespace App\Service;

use App\Entity\Schedule;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;

class ScheduleService
{
    private ScheduleRepository $scheduleRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ScheduleRepository $scheduleRepository, EntityManagerInterface $entityManager)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->entityManager = $entityManager;
    }

    public function createSchedule(string $day, string $time, int $examId, int $bunchId): Schedule
    {
        $schedule = new Schedule();
        $schedule->setDay($day)
                 ->setTime($time)
                 ->setExamId($examId)
                 ->setBunchId($bunchId);

        $this->entityManager->persist($schedule);
        $this->entityManager->flush();

        return $schedule;
    }

    public function updateSchedule(Schedule $schedule, array $data): Schedule
    {
        if (isset($data['day'])) {
            $schedule->setDay($data['day']);
        }

        if (isset($data['time'])) {
            $schedule->setTime($data['time']);
        }

        if (isset($data['examId'])) {
            $schedule->setExamId($data['examId']);
        }

        if (isset($data['bunchId'])) {
            $schedule->setBunchId($data['bunchId']);
        }

        $this->entityManager->flush();

        return $schedule;
    }

    public function deleteSchedule(Schedule $schedule): void
    {
        $this->entityManager->remove($schedule);
        $this->entityManager->flush();
    }

    public function getScheduleById(int $id): ?Schedule
    {
        return $this->scheduleRepository->find($id);
    }

    public function getAllSchedules(): array
    {
        return $this->scheduleRepository->findAll();
    }
}

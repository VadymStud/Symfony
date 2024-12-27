<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\User;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;

class CourseService
{
    private EntityManagerInterface $entityManager;
    private CourseRepository $courseRepository;

    public function __construct(EntityManagerInterface $entityManager, CourseRepository $courseRepository)
    {
        $this->entityManager = $entityManager;
        $this->courseRepository = $courseRepository;
    }

    public function createCourse(User $sender, User $recipient, string $content): Course
    {
        $course = new Course();
        $course->setSender($sender);
        $course->setRecipient($recipient);
        $course->setContent($content);
        $course->setTimestamp(new \DateTime());

        $this->entityManager->persist($course);
        $this->entityManager->flush();

        return $course;
    }

    public function updateMessage(Course $course, string $content): Course
    {
        $course->setContent($content);
        $course->setTimestamp(new \DateTime());

        $this->entityManager->flush();

        return $course;
    }

    public function deleteCourse(Course $course): void
    {
        $this->entityManager->remove($course);
        $this->entityManager->flush();
    }

    public function getCoursesByUser(User $user): array
    {
        return $this->courseRepository->findBy(['recipient' => $user]);
    }

    public function getCoursesBetweenUsers(User $user1, User $user2): array
    {
        return $this->courseRepository->findCoursesBetweenUsers($user1, $user2);
    }
}

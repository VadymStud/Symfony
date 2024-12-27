<?php

namespace App\Service;

use App\Entity\Lecturer; 
use App\Repository\LecturerRepository; 
use Doctrine\ORM\EntityManagerInterface;

class LecturerService
{
    private EntityManagerInterface $entityManager;
    private LecturerRepository $lecturerRepository; 

    public function __construct(EntityManagerInterface $entityManager, LecturerRepository $lecturerRepository)
    {
        $this->entityManager = $entityManager;
        $this->lecturerRepository = $lecturerRepository; 
    }

    public function createLecturer(string $name, string $email, ?string $phone = null): Lecturer 
    {
        $lecturer = new Lecturer(); 
        $lecturer->setName($name)
            ->setEmail($email)
            ->setPhone($phone);

        $this->entityManager->persist($lecturer);
        $this->entityManager->flush();

        return $lecturer;
    }

    public function updateLecturer(Lecturer $lecturer, string $name, string $email, ?string $phone = null): Lecturer 
    {
        $lecturer->setName($name)
            ->setEmail($email)
            ->setPhone($phone);

        $this->entityManager->flush();

        return $lecturer;
    }

    public function deleteLecturer(Lecturer $lecturer): void 
    {
        $this->entityManager->remove($lecturer);
        $this->entityManager->flush();
    }

    public function getLecturerById(int $id): ?Lecturer 
    {
        return $this->lecturerRepository->find($id); 
    }

    public function getAllLecturer(): array 
    {
        return $this->lecturerRepository->findAll(); 
    }
}

<?php

namespace App\Service;

use App\Entity\Bunch;
use App\Repository\BunchRepository;
use Doctrine\ORM\EntityManagerInterface;

class BunchService
{
    private EntityManagerInterface $entityManager;
    private BunchRepository $bunchRepository;

    public function __construct(EntityManagerInterface $entityManager, BunchRepository $bunchRepository)
    {
        $this->entityManager = $entityManager;
        $this->bunchRepository = $bunchRepository;
    }

    public function createBunch(string $name, ?string $description = null): Bunch
    {
        $bunch = new Bunch();
        $bunch->setName($name);
        $bunch->setDescription($description);

        $this->entityManager->persist($bunch);
        $this->entityManager->flush();

        return $bunch;
    }

    public function updateBunch(Bunch $bunch, string $name, ?string $description = null): Bunch
    {
        $bunch->setName($name);
        $bunch->setDescription($description);

        $this->entityManager->flush();

        return $bunch;
    }

    public function deleteBunch(Bunch $bunch): void
    {
        $this->entityManager->remove($bunch);
        $this->entityManager->flush();
    }

    public function findBunchById(int $id): ?Bunch
    {
        return $this->bunchRepository->find($id);
    }

    public function findAllBunchs(): array
    {
        return $this->bunchRepository->findAll();
    }
}

<?php

namespace App\Service;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;

class RoleService
{
    private RoleRepository $roleRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(RoleRepository $roleRepository, EntityManagerInterface $entityManager)
    {
        $this->roleRepository = $roleRepository;
        $this->entityManager = $entityManager;
    }

    public function createRole(array $data): Role
    {
        $role = new Role();
        $role->setName($data['name']);
        $role->setDescription($data['description']);
        
        $this->entityManager->persist($role);
        $this->entityManager->flush();

        return $role;
    }

    public function updateRole(int $id, array $data): Role
    {
        $role = $this->roleRepository->find($id);
        if (!$role) {
            throw new \Exception('Role not found');
        }

        $role->setName($data['name']);
        $role->setDescription($data['description']);

        $this->entityManager->flush();

        return $role;
    }

    public function deleteRole(int $id): void
    {
        $role = $this->roleRepository->find($id);
        if (!$role) {
            throw new \Exception('Role not found');
        }

        $this->entityManager->remove($role);
        $this->entityManager->flush();
    }
}

<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllStudentsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('student');

        // Фільтрація за ім'ям студента
        if (isset($data['name'])) {
            $queryBuilder->andWhere('student.name LIKE :name')
                         ->setParameter('name', '%' . $data['name'] . '%');
        }

        // Фільтрація за електронною поштою студента
        if (isset($data['email'])) {
            $queryBuilder->andWhere('student.email LIKE :email')
                         ->setParameter('email', '%' . $data['email'] . '%');
        }

        // Пагінація
        $paginator = new Paginator($queryBuilder);
        $totalItems = count($paginator);
        $totalPages = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'students' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $totalPages,
            'totalItems' => $totalItems
        ];
    }
}

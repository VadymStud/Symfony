<?php

namespace App\Repository;

use App\Entity\Lecturer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class LecturerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lecturer::class);
    }

    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllLecturersByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('lecturer');

        if (isset($data['name'])) {
            $queryBuilder->andWhere('lecturer.name LIKE :name')
                         ->setParameter('name', '%' . $data['name'] . '%');
        }

        if (isset($data['email'])) {
            $queryBuilder->andWhere('lecturer.email LIKE :email')
                         ->setParameter('email', '%' . $data['email'] . '%');
        }

        $paginator = new Paginator($queryBuilder);
        $totalItems = count($paginator);
        $totalPages = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'lecturer' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $totalPages,
            'totalItems' => $totalItems
        ];
    }
}

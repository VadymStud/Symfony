<?php

namespace App\Repository;

use App\Entity\Grade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class GradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grade::class);
    }

    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllGradesByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('grade');

        if (isset($data['grade'])) {
            $queryBuilder->andWhere('grade.grade LIKE :grade')
                         ->setParameter('grade', '%' . $data['grade'] . '%');
        }

        if (isset($data['subject'])) {
            $queryBuilder->andWhere('grade.subject LIKE :subject')
                         ->setParameter('subject', '%' . $data['subject'] . '%');
        }

        $paginator = new Paginator($queryBuilder);
        $totalItems = count($paginator);
        $totalPages = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'grades' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $totalPages,
            'totalItems' => $totalItems
        ];
    }
}

<?php

namespace App\Repository;

use App\Entity\Instructor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class InstructorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Instructor::class);
    }

    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllInstructorsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('instructor');

        if (isset($data['subject'])) {
            $queryBuilder->andWhere('instructor.subject LIKE :subject')
                         ->setParameter('subject', '%' . $data['subject'] . '%');
        }

        if (isset($data['experience_years'])) {
            $queryBuilder->andWhere('instructor.experienceYears >= :experience_years')
                         ->setParameter('experience_years', $data['experience_years']);
        }


        $paginator = new Paginator($queryBuilder);
        $totalItems = count($paginator);
        $totalPages = ceil($totalItems / $itemsPerPage);


        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'instructors' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $totalPages,
            'totalItems' => $totalItems
        ];
    }
}

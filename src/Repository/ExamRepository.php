<?php

namespace App\Repository;

use App\Entity\Exam;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ExamRepository extends EntityRepository
{
    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllExamsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('exam');


        if (isset($data['name'])) {
            $queryBuilder->andWhere('exam.name LIKE :name')
                         ->setParameter('name', '%' . $data['name'] . '%');
        }

 
        if (isset($data['instructor'])) {
            $queryBuilder->andWhere('exam.instructor LIKE :instructor')
                         ->setParameter('instructor', '%' . $data['instructor'] . '%');
        }

        // Фільтрація за датою проведення
        if (isset($data['date'])) {
            $queryBuilder->andWhere('exam.date = :date')
                         ->setParameter('date', $data['date']);
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
            'exams' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $totalPages,
            'totalItems' => $totalItems
        ];
    }
}

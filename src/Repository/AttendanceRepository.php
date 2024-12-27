<?php

namespace App\Repository;

use App\Entity\Attendance;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AttendanceRepository extends EntityRepository
{
    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllAttendanceByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('attendance');


        if (isset($data['date'])) {
            $queryBuilder->andWhere('attendance.date LIKE :date')
                         ->setParameter('date', '%' . $data['date'] . '%');
        }


        if (isset($data['student_id'])) {
            $queryBuilder->andWhere('attendance.student = :student')
                         ->setParameter('student', $data['student_id']);
        }


        if (isset($data['exam_id'])) {
            $queryBuilder->andWhere('attendance.exam = :exam')
                         ->setParameter('exam', $data['exam_id']);
        }


        $paginator = new Paginator($queryBuilder);
        $totalItems = count($paginator);
        $totalPages = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'attendance' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $totalPages,
            'totalItems' => $totalItems
        ];
    }
}

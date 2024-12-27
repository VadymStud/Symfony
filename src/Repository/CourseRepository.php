<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllCoursesByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('course');


        if (isset($data['instructor'])) {
            $queryBuilder->andWhere('course.instructor LIKE :instructor')
                         ->setParameter('instructor', '%' . $data['instructor'] . '%');
        }


        if (isset($data['student'])) {
            $queryBuilder->andWhere('course.student LIKE :student')
                         ->setParameter('student', '%' . $data['student'] . '%');
        }


        if (isset($data['content'])) {
            $queryBuilder->andWhere('course.content LIKE :content')
                         ->setParameter('content', '%' . $data['content'] . '%');
        }


        $paginator = new Paginator($queryBuilder);
        $totalItems = count($paginator);
        $totalPages = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'course' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $totalPages,
            'totalItems' => $totalItems
        ];
    }
}

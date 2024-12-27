<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepository extends EntityRepository
{
    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllUsersByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('user');

        if (isset($data['username'])) {
            $queryBuilder->andWhere('user.username LIKE :username')
                         ->setParameter('username', '%' . $data['username'] . '%');
        }

        if (isset($data['email'])) {
            $queryBuilder->andWhere('user.email LIKE :email')
                         ->setParameter('email', '%' . $data['email'] . '%');
        }

        if (isset($data['role'])) {
            $queryBuilder->andWhere('user.role = :role')
                         ->setParameter('role', $data['role']);
        }

        $paginator = new Paginator($queryBuilder);
        $totalItems = count($paginator);
        $totalPages = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'users' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $totalPages,
            'totalItems' => $totalItems
        ];
    }
}

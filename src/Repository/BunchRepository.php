<?php

namespace App\Repository;

use App\Entity\Bunch;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class BunchRepository extends EntityRepository
{
    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return array
     */
    public function getAllBunchsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('bunch');

        if (isset($data['name'])) {
            $queryBuilder->andWhere('bunch.name LIKE :name')
                         ->setParameter('name', '%' . $data['name'] . '%');
        }

        if (isset($data['description'])) {
            $queryBuilder->andWhere('bunch.description LIKE :description')
                         ->setParameter('description', '%' . $data['description'] . '%');
        }

        $paginator = new Paginator($queryBuilder);
        $totalItems = count($paginator);
        $totalPages = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'bunchs' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $totalPages,
            'totalItems' => $totalItems
        ];
    }
}

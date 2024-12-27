<?php

namespace App\ApiPlatform\Extension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Student;

class StudentCollectionExtension implements QueryCollectionExtensionInterface
{
    public function applyToCollection(QueryBuilder $queryBuilder, string $resourceClass, string $operationName = null)
    {
        if ($resourceClass === Student::class) {
            $queryBuilder->andWhere('o.status = :status')
                ->setParameter('status', 'active');
        }
    }
}

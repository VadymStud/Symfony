<?php

namespace App\ApiPlatform\Extension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use Doctrine\ORM\QueryBuilder;

class FilterExamByNameExtension implements QueryCollectionExtensionInterface
{
    public function applyToCollection(QueryBuilder $queryBuilder, string $resourceClass)
    {

        if ($resourceClass === 'App\Entity\Exam') {
            $alias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere("{$alias}.name LIKE :name")
                         ->setParameter('name', '%Math%'); 
        }
    }
}

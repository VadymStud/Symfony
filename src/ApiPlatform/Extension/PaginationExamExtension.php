<?php

namespace App\ApiPlatform\Extension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use Doctrine\ORM\QueryBuilder;

class PaginationExamExtension implements QueryCollectionExtensionInterface
{
    public function applyToCollection(QueryBuilder $queryBuilder, string $resourceClass)
    {
        if ($resourceClass === 'App\Entity\Exam') {
            $queryBuilder->setMaxResults(10);  // Обмеження на кількість результатів
        }
    }
}

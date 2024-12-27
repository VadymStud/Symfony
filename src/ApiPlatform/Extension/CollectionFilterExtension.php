<?php

namespace App\ApiPlatform\Extension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class CollectionFilterExtension implements QueryCollectionExtensionInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, string $resourceClass, string $operationName = null)
    {

        if ($resourceClass === User::class) {
            $user = $this->security->getUser();
            if ($user) {
                
                $queryBuilder->andWhere('o.role = :role')
                    ->setParameter('role', 'ROLE_USER');
            }
        }
    }
}

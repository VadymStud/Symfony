<?php


namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Entity\User;

class UserPostUpdateListener
{
    public function postUpdate(User $user, LifecycleEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
    }
}

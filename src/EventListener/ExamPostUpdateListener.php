<?php

namespace App\EventListener;

use App\Entity\Exam;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ExamPostUpdateListener
{
    public function postUpdate(Exam $lesson, LifecycleEventArgs $args)
    {
        $logger = $args->getEntityManager()->getRepository('App:Exam');
        $logger->addLog("Exam updated: " . $exam->getId());
    }
}

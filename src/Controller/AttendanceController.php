<?php

namespace App\Controller;

use App\Entity\Attendance;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AttendanceController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function getCollection(Request $request): JsonResponse
    {

        if (!$this->getUser()) {
            throw new AccessDeniedException('Такого користувача не існує');
        }

        $requestData = $request->query->all();
        $itemsPerPage = isset($requestData['itemsPerPage']) ? (int) $requestData['itemsPerPage'] : 10;
        $page = isset($requestData['page']) ? (int) $requestData['page'] : 1;

        $attendanceData = $this->entityManager->getRepository(Attendance::class)->getAllAttendanceByFilter($requestData, $itemsPerPage, $page);

        return new JsonResponse($attendanceData);
    }
}

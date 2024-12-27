<?php

namespace App\Controller;

use App\Service\LecturerService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Lecturer;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class LecturerController extends AbstractController
{
    private LecturerService $lecturerService;
    private EntityManagerInterface $entityManager;

    public function __construct(LecturerService $lecturerService, EntityManagerInterface $entityManager)
    {
        $this->lecturerService = $lecturerService;
        $this->entityManager = $entityManager;
    }


    public function getCollection(Request $request): JsonResponse
    {
        $requestData = $request->query->all();
        $itemsPerPage = isset($requestData['itemsPerPage']) ? (int) $requestData['itemsPerPage'] : 10;
        $page = isset($requestData['page']) ? (int) $requestData['page'] : 1;

        $lecturerData = $this->entityManager->getRepository(Lecturer::class)->getAllLecturerByFilter($requestData, $itemsPerPage, $page);

        return new JsonResponse($lecturerData);
    }
}
<?php

namespace App\Controller;

use App\Service\GradeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class GradeController extends AbstractController
{
    private GradeService $gradeService;
    private EntityManagerInterface $entityManager;

    public function __construct(GradeService $gradeService, EntityManagerInterface $entityManager)
    {
        $this->gradeService = $gradeService;
        $this->entityManager = $entityManager;
    }


    public function getCollection(Request $request): JsonResponse
    {
        $requestData = $request->query->all();
        $itemsPerPage = isset($requestData['itemsPerPage']) ? (int) $requestData['itemsPerPage'] : 10;
        $page = isset($requestData['page']) ? (int) $requestData['page'] : 1;

        $gradesData = $this->entityManager->getRepository(Grade::class)->getAllGradesByFilter($requestData, $itemsPerPage, $page);

        return new JsonResponse($gradesData);
    }
}

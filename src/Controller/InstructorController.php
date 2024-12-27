<?php

namespace App\Controller;

use App\Service\InstructorService;
use App\Entity\Instructor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class InstructorController extends AbstractController
{
    private InstructorService $instructorService;
    private EntityManagerInterface $entityManager;

    public function __construct(InstructorService $instructorService, EntityManagerInterface $entityManager)
    {
        $this->instructorService = $instructorService;
        $this->entityManager = $entityManager;
    }

    #[Route('/instructors', name: 'app_get_instructors_collection', methods: ['GET'])]
    public function getCollection(Request $request, AuthorizationCheckerInterface $authChecker): JsonResponse
    {

        if (!$authChecker->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('Немає доступу');
        }

        $requestData = $request->query->all();
        $itemsPerPage = isset($requestData['itemsPerPage']) ? (int) $requestData['itemsPerPage'] : 10;
        $page = isset($requestData['page']) ? (int) $requestData['page'] : 1;

        $InstructorData = $this->entityManager->getRepository(Instructor::class)->getAllInstructorsByFilter($requestData, $itemsPerPage, $page);

        return new JsonResponse($instructorsData);
    }
}

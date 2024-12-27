<?php

namespace App\Controller;

use App\Service\CourseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;

class CourseController extends AbstractController
{
    private CourseService $courseService;
    private EntityManagerInterface $entityManager;
    private JWTManager $jwtManager;

    public function __construct(CourseService $courseService, EntityManagerInterface $entityManager, JWTManager $jwtManager)
    {
        $this->courseService = $courseService;
        $this->entityManager = $entityManager;
        $this->jwtManager = $jwtManager;
    }

    #[Route('/coursess', name: 'app_get_courses_collection', methods: ['GET'])]
    public function getCollection(Request $request, AuthorizationCheckerInterface $authorizationChecker): JsonResponse
    {

        if (!$authorizationChecker->isGranted('ROLE_USER')) {
            return new JsonResponse(['error' => 'Access Denied'], JsonResponse::HTTP_FORBIDDEN);
        }

        $requestData = $request->query->all();
        $itemsPerPage = isset($requestData['itemsPerPage']) ? (int) $requestData['itemsPerPage'] : 10;
        $page = isset($requestData['page']) ? (int) $requestData['page'] : 1;

        // Отримання повідомлень з фільтрацією
        $coursesData = $this->entityManager->getRepository(Course::class)->getAllCoursesByFilter($requestData, $itemsPerPage, $page);

        return new JsonResponse($coursesData);
    }
}

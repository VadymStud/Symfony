<?php

namespace App\Controller;

use App\Service\StudentService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class StudentController extends AbstractController
{
    private StudentService $studentService;
    private EntityManagerInterface $entityManager;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(
        StudentService $studentService,
        EntityManagerInterface $entityManager,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->studentService = $studentService;
        $this->entityManager = $entityManager;
        $this->authorizationChecker = $authorizationChecker;
    }


    public function getCollection(Request $request): JsonResponse
    {

        if (!$this->authorizationChecker->isGranted('ROLE_USER')) {
            return new JsonResponse(['message' => 'Access Denied'], JsonResponse::HTTP_FORBIDDEN);
        }


        $requestData = $request->query->all();
        $itemsPerPage = isset($requestData['itemsPerPage']) ? (int) $requestData['itemsPerPage'] : 10;
        $page = isset($requestData['page']) ? (int) $requestData['page'] : 1;


        $studentsData = $this->entityManager->getRepository(Student::class)->getAllStudentsByFilter($requestData, $itemsPerPage, $page);

        return new JsonResponse($studentsData);
    }



    public function createStudent(Request $request): JsonResponse
    {

        if (!$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['message' => 'Access Denied'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = json_decode($request->getContent(), true);
        $student = $this->studentService->createStudent($data);

        return new JsonResponse([
            'status' => 'success',
            'student' => [
                'id' => $student->getId(),
                'name' => $student->getName(),
                'email' => $student->getEmail(),
            ]
        ]);
    }

}

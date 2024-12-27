<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class UserController
{
    private UserService $userService;
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(UserService $userService, ValidatorInterface $validator, EntityManagerInterface $entityManager, Security $security)
    {
        $this->userService = $userService;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }


    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse(['error' => 'Invalid JSON format.'], JsonResponse::HTTP_BAD_REQUEST);
        }


        $violations = $this->validator->validate($data);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }

            return new JsonResponse(['errors' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        }


        $user = $this->userService->createUser($data);

        return new JsonResponse(['id' => $user->getId()], JsonResponse::HTTP_CREATED);
    }


    public function getUsersCollection(Request $request): JsonResponse
    {

        $user = $this->security->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'Unauthorized'], JsonResponse::HTTP_UNAUTHORIZED);
        }


        if (!$this->security->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['error' => 'Access denied'], JsonResponse::HTTP_FORBIDDEN);
        }


        $requestData = $request->query->all();
        $itemsPerPage = isset($requestData['itemsPerPage']) ? (int) $requestData['itemsPerPage'] : 10;
        $page = isset($requestData['page']) ? (int) $requestData['page'] : 1;

        $usersData = $this->entityManager->getRepository(User::class)->getAllUsersByFilter($requestData, $itemsPerPage, $page);

        return new JsonResponse($usersData);
    }
}

<?php


namespace App\Controller;

use App\Service\RoleService;
use App\Entity\Role;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RoleController extends AbstractController
{
    private RoleService $roleService;
    private EntityManagerInterface $entityManager;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(RoleService $roleService, EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->roleService = $roleService;
        $this->entityManager = $entityManager;
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route('/roles', name: 'app_get_roles_collection', methods: ['GET'])]
    public function getCollection(Request $request): JsonResponse
    {
        // Перевірка, чи користувач авторизований за допомогою JWT
        if (!$this->authorizationChecker->isGranted('ROLE_USER')) {
            return new JsonResponse(['message' => 'Access Denied'], 403);
        }

        $requestData = $request->query->all();
        $itemsPerPage = isset($requestData['itemsPerPage']) ? (int) $requestData['itemsPerPage'] : 10;
        $page = isset($requestData['page']) ? (int) $requestData['page'] : 1;

        $rolesData = $this->entityManager->getRepository(Role::class)->getAllRolesByFilter($requestData, $itemsPerPage, $page);

        return new JsonResponse($rolesData);
    }
}

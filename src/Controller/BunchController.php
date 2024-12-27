<?php

namespace App\Controller;

use App\Entity\Brunch;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BrunchController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
        $this->authorizationChecker = $authorizationChecker;
    }


    public function getCollection(Request $request): JsonResponse
    {

        if (!$this->authorizationChecker->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('You do not have permission to access this resource');
        }

        $requestData = $request->query->all();
        $itemsPerPage = isset($requestData['itemsPerPage']) ? (int) $requestData['itemsPerPage'] : 10;
        $page = isset($requestData['page']) ? (int) $requestData['page'] : 1;


        $brunchsData = $this->entityManager->getRepository(Brunch::class)->getAllBrunchsByFilter($requestData, $itemsPerPage, $page);


        return new JsonResponse($brunchsData);
    }
}

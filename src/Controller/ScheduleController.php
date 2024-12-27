<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Service\ScheduleService;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/schedule')]
class ScheduleController extends AbstractController
{
    private $scheduleRepository;
    private $scheduleService;

    public function __construct(ScheduleRepository $scheduleRepository, ScheduleService $scheduleService)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleService = $scheduleService;
    }

    #[Route('/', name: 'schedule_index')]
    public function index(AuthorizationCheckerInterface $authChecker): Response
    {
        if (!$authChecker->isGranted('ROLE_USER')) {
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $schedules = $this->scheduleRepository->findAll();

        return $this->render('schedule/index.html.twig', [
            'schedules' => $schedules,
        ]);
    }

    #[Route('/new', name: 'schedule_new')]
    public function new(Request $request, AuthorizationCheckerInterface $authChecker): Response
    {
        if (!$authChecker->isGranted('ROLE_USER')) {
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $schedule = new Schedule();
        
        $form = $this->createFormBuilder($schedule)
            ->add('name', TextType::class)
            ->add('date', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Schedule'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->scheduleService->create($schedule);

            return $this->redirectToRoute('schedule_index');
        }

        return $this->render('schedule/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'schedule_show')]
    public function show(int $id, AuthorizationCheckerInterface $authChecker): Response
    {
        if (!$authChecker->isGranted('ROLE_USER')) {
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $schedule = $this->scheduleRepository->find($id);

        if (!$schedule) {
            throw $this->createNotFoundException('Графік відсутній для ' . $id);
        }

        return $this->render('schedule/show.html.twig', [
            'schedule' => $schedule,
        ]);
    }

    #[Route('/{id}/edit', name: 'schedule_edit')]
    public function edit(Request $request, Schedule $schedule, AuthorizationCheckerInterface $authChecker): Response
    {
        if (!$authChecker->isGranted('ROLE_USER')) {
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $form = $this->createFormBuilder($schedule)
            ->add('name', TextType::class)
            ->add('date', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Update Schedule'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->scheduleService->update($schedule);

            return $this->redirectToRoute('schedule_index');
        }

        return $this->render('schedule/edit.html.twig', [
            'form' => $form->createView(),
            'schedule' => $schedule,
        ]);
    }

    #[Route('/{id}/delete', name: 'schedule_delete')]
    public function delete(int $id, AuthorizationCheckerInterface $authChecker): Response
    {
        if (!$authChecker->isGranted('ROLE_USER')) {
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $schedule = $this->scheduleRepository->find($id);

        if ($schedule) {
            $this->scheduleService->delete($schedule);
        }

        return $this->redirectToRoute('schedule_index');
    }
}

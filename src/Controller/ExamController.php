<?php

namespace App\Controller;

use App\Entity\Exam;
use App\Repository\ExamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ECxamontroller
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private ExamRepository $examRepository;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, ExamRepository $examRepository)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->examRepository = $examRepository;
    }


    public function createExam(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


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


        $exam = new Exam();
        $exam->setName($data['name'])
               ->setSchedule($data['schedule']);
        
        // Збереження
        $this->entityManager->persist($exam);
        $this->entityManager->flush();

        return new JsonResponse(['id' => $exam->getId()], JsonResponse::HTTP_CREATED);
    }


    public function getExams(): JsonResponse
    {
        $exams = $this->examRepository->findAll();

        $data = [];
        foreach ($exams as $exam) {
            $data[] = [
                'id' => $exam->getId(),
                'name' => $exam->getName(),
                'schedule' => $exam->getSchedule(),
            ];
        }

        return new JsonResponse($data);
    }
}

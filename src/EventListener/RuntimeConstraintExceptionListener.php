<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RuntimeConstraintExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidatorException) {
            
            $errors = [];
            foreach ($exception->getViolations() as $violation) {
                $errors[] = [
                    'field' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }

            $response = new JsonResponse([
                'status' => 'error',
                'errors' => $errors,
            ], Response::HTTP_BAD_REQUEST);

            $event->setResponse($response);
        }
    }
}

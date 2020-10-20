<?php


namespace App\EventListener;


use App\Exception\DomainException;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ApiExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $throwable = $event->getThrowable();

        if($throwable instanceof EntityNotFoundException){
            $response = new JsonResponse(['errors' => 'Entity not found.'], Response::HTTP_NOT_FOUND);
            $event->setResponse($response);

            return;
        }

        if ($throwable instanceof DomainException) {
            $response = new JsonResponse($throwable->getMessage(), $throwable->getStatusCode(), [], true);
            $event->setResponse($response);

            return;
        }

    }
}
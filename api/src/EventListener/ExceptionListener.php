<?php

namespace App\EventListener;

use App\Exception\NotFoundException;
use App\Exception\ValidationException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::EXCEPTION)]
class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof NotFoundException) {
            $event->setResponse(new JsonResponse(
                ['message' => $exception->getMessage()],
                Response::HTTP_NOT_FOUND,
            ));
        } elseif ($exception instanceof ValidationException) {
            $event->setResponse(new JsonResponse(
                ['message' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST,
            ));
        }
    }
}

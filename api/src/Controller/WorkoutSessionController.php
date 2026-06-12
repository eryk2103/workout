<?php

namespace App\Controller;

use App\Dto\CreateWorkoutSessionDto;
use App\Dto\UpdateWorkoutSessionDto;
use App\Mapper\WorkoutSessionMapper;
use App\Service\WorkoutSessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/workout-sessions')]
class WorkoutSessionController extends AbstractController
{
    public function __construct(
        private WorkoutSessionService $service,
        private WorkoutSessionMapper $mapper,
    ) {}

    #[Route('', methods: ['GET'])]
    public function index(
        #[MapQueryParameter] ?string $startDate = null,
        #[MapQueryParameter] ?string $endDate = null,
    ): JsonResponse
    {
        $sessions = $this->service->get(
            $startDate !== null ? new \DateTime($startDate) : null,
            $endDate !== null ? new \DateTime($endDate) : null,
        );
        $dtos = array_map(
            fn($session) => $this->mapper->toDto($session, $this->service->getWorkoutExercises($session)),
            $sessions,
        );

        return $this->json($dtos);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $session = $this->service->getById($id);

        return $this->json($this->mapper->toDto($session, $this->service->getWorkoutExercises($session)));
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateWorkoutSessionDto $dto): JsonResponse
    {
        $session = $this->service->create($dto);

        return $this->json($this->mapper->toDto($session), Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] UpdateWorkoutSessionDto $dto): JsonResponse
    {
        $session = $this->service->update($id, $dto);

        return $this->json($this->mapper->toDto($session));
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}

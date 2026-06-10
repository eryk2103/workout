<?php

namespace App\Controller;

use App\Dto\CreateExerciseSessionDto;
use App\Dto\UpdateExerciseSessionDto;
use App\Mapper\ExerciseSessionMapper;
use App\Service\ExerciseSessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/exercise-sessions')]
class ExerciseSessionController extends AbstractController
{
    public function __construct(private ExerciseSessionService $service, private ExerciseSessionMapper $mapper) {}

    #[Route('', methods: ['GET'])]
    public function index(#[MapQueryParameter] ?int $workoutSessionId = null): JsonResponse
    {
        $sessions = $this->service->get($workoutSessionId);
        $dtos = array_map(fn($session) => $this->mapper->toDto($session), $sessions);

        return $this->json($dtos);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $session = $this->service->getById($id);

        return $this->json($this->mapper->toDto($session));
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateExerciseSessionDto $dto): JsonResponse
    {
        $session = $this->service->create($dto);

        return $this->json($this->mapper->toDto($session), Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] UpdateExerciseSessionDto $dto): JsonResponse
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

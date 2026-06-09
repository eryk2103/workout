<?php

namespace App\Controller;

use App\Dto\CreateWorkoutDto;
use App\Dto\UpdateWorkoutDto;
use App\Mapper\WorkoutMapper;
use App\Service\WorkoutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/workouts')]
class WorkoutController extends AbstractController
{
    public function __construct(private WorkoutService $service, private WorkoutMapper $mapper) {}

    #[Route('', methods: ['GET'])]
    public function index(#[MapQueryParameter] string $search = ''): JsonResponse
    {
        $workouts = $this->service->getAll($search);
        $dtos = array_map(fn($workout) => $this->mapper->toDto($workout), $workouts);

        return $this->json($dtos);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $workoutWithExercises = $this->service->getById($id);

        return $this->json($this->mapper->toDto($workoutWithExercises['workout'], $workoutWithExercises['exercises']));
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateWorkoutDto $dto): JsonResponse
    {
        $workout = $this->service->create($dto);

        return $this->json($this->mapper->toDto($workout), Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] UpdateWorkoutDto $dto): JsonResponse
    {
        $workout = $this->service->update($id, $dto);

        return $this->json($this->mapper->toDto($workout));
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Controller;

use App\Dto\ExerciseDto;
use App\Mapper\ExerciseMapper;
use App\Service\ExerciseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/exercises')]
class ExerciseController extends AbstractController
{
    public function __construct(private ExerciseService $service, private ExerciseMapper $mapper) {}

    #[Route('', methods: ['GET'])]
    public function index(#[MapQueryParameter] string $search = ''): JsonResponse
    {
        $exercises = $this->service->getAll($search);
        $dtos = array_map(fn($exercise) => $this->mapper->toDto($exercise), $exercises);

        return $this->json($dtos);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $exercise = $this->service->getById($id);

        return $this->json($this->mapper->toDto($exercise));
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload] ExerciseDto $dto): JsonResponse
    {
        $exercise = $this->service->create($dto->name);

        return $this->json($this->mapper->toDto($exercise), Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] ExerciseDto $dto): JsonResponse
    {
        $exercise = $this->service->update($id, $dto->name);

        return $this->json($this->mapper->toDto($exercise));
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}

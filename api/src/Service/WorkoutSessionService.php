<?php

namespace App\Service;

use App\Dto\CreateWorkoutSessionDto;
use App\Dto\UpdateWorkoutSessionDto;
use App\Entity\WorkoutSession;
use App\Exception\WorkoutNotFoundException;
use App\Exception\WorkoutSessionNotFoundException;
use App\Repository\WorkoutRepository;
use App\Repository\WorkoutSessionRepository;
use Doctrine\ORM\EntityManagerInterface;

class WorkoutSessionService
{
    public function __construct(
        private WorkoutSessionRepository $repository,
        private WorkoutRepository $workoutRepository,
        private EntityManagerInterface $em,
    ) {}

    public function get(): array
    {
        return $this->repository->findAll();
    }

    public function getById(int $id): WorkoutSession
    {
        $workoutSession = $this->repository->find($id);
        if($workoutSession === null) {
            throw new WorkoutSessionNotFoundException();
        }

        return $workoutSession;
    }

    public function create(CreateWorkoutSessionDto $dto): WorkoutSession
    {
        $workout = $this->workoutRepository->find($dto->workoutId);
        if($workout === null) {
            throw new WorkoutNotFoundException();
        }

        $workoutSession = new WorkoutSession()
            ->setWorkout($workout)
            ->setScheduledAt($dto->scheduledAt);

        $this->em->persist($workoutSession);
        $this->em->flush();

        return $workoutSession;
    }

    public function update(int $id, UpdateWorkoutSessionDto $dto): WorkoutSession
    {
        $workoutSession = $this->getById($id);
        $workoutSession->setScheduledAt($dto->scheduledAt);

        $this->em->persist($workoutSession);
        $this->em->flush();

        return $workoutSession;
    }

    public function delete(int $id): void
    {
        $workoutSession = $this->getById($id);

        $this->em->remove($workoutSession);
        $this->em->flush();
    }
}

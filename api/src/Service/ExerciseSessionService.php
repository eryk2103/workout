<?php

namespace App\Service;

use App\Dto\CreateExerciseSessionDto;
use App\Dto\UpdateExerciseSessionDto;
use App\Entity\ExerciseSession;
use App\Exception\ExerciseNotFoundException;
use App\Exception\ExerciseSessionNotFoundException;
use App\Exception\ValidationException;
use App\Exception\WorkoutSessionNotFoundException;
use App\Repository\ExerciseRepository;
use App\Repository\ExerciseSessionRepository;
use App\Repository\WorkoutSessionRepository;
use Doctrine\ORM\EntityManagerInterface;

class ExerciseSessionService
{
    public function __construct(
        private ExerciseSessionRepository $repository,
        private EntityManagerInterface $em,
        private ExerciseRepository $exerciseRepository,
        private WorkoutSessionRepository $workoutSessionRepository,
    ) {}

    public function get(?int $workoutSessionId = null): array
    {
        return $this->repository->findByFilters($workoutSessionId);
    }

    public function getById(int $id): ?ExerciseSession
    {
        $exerciseSession = $this->repository->find($id);
        if ($exerciseSession === null) {
            throw new ExerciseSessionNotFoundException();
        }
        return $exerciseSession;
    }

    public function create(CreateExerciseSessionDto $dto): ExerciseSession
    {
        $exercise = $this->exerciseRepository->find($dto->exerciseId);
        if ($exercise === null) {
            throw new ExerciseNotFoundException();
        }

        $workoutSession = null;
        if($dto->workoutSessionId !== null) {
            $workoutSession = $this->workoutSessionRepository->find($dto->workoutSessionId);
            if ($workoutSession === null) {
                throw new WorkoutSessionNotFoundException();
            }
        }

        $exerciseSession = new ExerciseSession()
            ->setExercise($exercise)
            ->setWorkoutSession($workoutSession)
            ->setScheduledAt($dto->scheduledAt)
            ->setReps($dto->reps)
            ->setSet($dto->set)
            ->setWeight($dto->weight);

        $this->em->persist($exerciseSession);
        $this->em->flush();

        return $exerciseSession;
    }

    public function update(int $id, UpdateExerciseSessionDto $dto): ExerciseSession
    {
        $exerciseSession = $this->getById($id);

        if($dto->startAt > $dto->endAt) {
            throw new ValidationException('End time must be greater than start at.');
        }

        $exerciseSession->setScheduledAt($dto->scheduledAt)
            ->setReps($dto->reps)
            ->setSet($dto->set)
            ->setWeight($dto->weight)
            ->setStartAt($dto->startAt)
            ->setEndAt($dto->endAt);

        $this->em->persist($exerciseSession);
        $this->em->flush();

        return $exerciseSession;
    }

    public function delete(int $id): ExerciseSession
    {
        $exerciseSession = $this->getById($id);

        $this->em->remove($exerciseSession);
        $this->em->flush();

        return $exerciseSession;
    }
}

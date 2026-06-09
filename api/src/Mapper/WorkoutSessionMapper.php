<?php

namespace App\Mapper;

use App\Dto\CreateWorkoutSessionDto;
use App\Dto\WorkoutSessionDto;
use App\Entity\Workout;
use App\Entity\WorkoutSession;

class WorkoutSessionMapper
{
    public function __construct(private WorkoutMapper $workoutMapper) {}

    public function toDto(WorkoutSession $session): WorkoutSessionDto
    {
        return new WorkoutSessionDto(
            id: $session->getId(),
            scheduledAt: $session->getScheduledAt(),
            workout: $this->workoutMapper->toDto($session->getWorkout()),
        );
    }

    public function fromDto(CreateWorkoutSessionDto $dto, Workout $workout): WorkoutSession
    {
        return new WorkoutSession()
            ->setScheduledAt($dto->scheduledAt)
            ->setWorkout($workout);
    }
}

<?php

namespace App\Mapper;

use App\Dto\ExerciseSessionDto;
use App\Entity\ExerciseSession;

class ExerciseSessionMapper
{
    public function __construct(
        private ExerciseMapper $exerciseMapper,
        private WorkoutSessionMapper $workoutSessionMapper,
    ) {}

    public function toDto(ExerciseSession $session): ExerciseSessionDto
    {
        $workoutSession = $session->getWorkoutSession();

        return new ExerciseSessionDto(
            id: $session->getId(),
            exercise: $this->exerciseMapper->toDto($session->getExercise()),
            scheduledAt: $session->getScheduledAt(),
            reps: $session->getReps(),
            set: $session->getSet(),
            weight: $session->getWeight(),
            startAt: $session->getStartAt(),
            endAt: $session->getEndAt(),
            workoutSession: $workoutSession !== null ? $this->workoutSessionMapper->toDto($workoutSession) : null,
        );
    }
}

<?php

namespace App\Dto;

class ExerciseSessionDto
{
    public function __construct(
        public int $id,
        public ExerciseDto $exercise,
        public \DateTime $scheduledAt,
        public ?int $reps,
        public ?int $set,
        public ?int $weight,
        public ?\DateTime $startAt,
        public ?\DateTime $endAt,
        public ?WorkoutSessionDto $workoutSession,
    ) {}
}

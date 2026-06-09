<?php

namespace App\Dto;

class CreateExerciseSessionDto
{
    public function __construct(
        public int $exerciseId,
        public \DateTime $scheduledAt,
        public ?int $reps = null,
        public ?int $set = null,
        public ?int $weight = null,
        public ?int $workoutSessionId = null,
    ) {}
}

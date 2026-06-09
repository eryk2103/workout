<?php

namespace App\Dto;

class CreateWorkoutSessionDto
{
    public function __construct(
        public int $workoutId,
        public \DateTime $scheduledAt,
    ) {}
}

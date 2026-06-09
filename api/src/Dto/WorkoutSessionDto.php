<?php

namespace App\Dto;


class WorkoutSessionDto
{
    public function __construct(
        public int $id,
        public \DateTime $scheduledAt,
        public WorkoutDto $workout,
    ) {}
}

<?php

namespace App\Dto;

class UpdateExerciseSessionDto
{
    public function __construct(
        public \DateTime $scheduledAt,
        public ?int $reps = null,
        public ?int $set = null,
        public ?int $weight = null,
        public ?\DateTime $startAt = null,
        public ?\DateTime $endAt = null,
    ) {}
}

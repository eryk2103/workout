<?php

namespace App\Dto;

class UpdateWorkoutSessionDto
{
    public function __construct(
        public \DateTime $scheduledAt,
    ) {}
}

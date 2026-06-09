<?php

namespace App\Dto;

class UpdateWorkoutDto
{
    public function __construct(
        public string $name,
        public array $exercisesIds
    ) {}
}

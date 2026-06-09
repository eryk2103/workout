<?php

namespace App\Dto;

class CreateWorkoutDto
{
    public function __construct(
        public string $name,
        public array $exercisesIds
    ) {}
}

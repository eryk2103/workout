<?php

namespace App\Dto;

class WorkoutDto
{
    public function __construct(
        public int $id,
        public string $name,
        public array $exercises = [],
    ) {}
}

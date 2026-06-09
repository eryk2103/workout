<?php

namespace App\Dto;

class ExerciseDto
{
    public function __construct(
        public string $name,
        public ?int $id = null,
    ) {}
}

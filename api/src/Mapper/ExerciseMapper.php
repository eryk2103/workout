<?php

namespace App\Mapper;

use App\Dto\ExerciseDto;
use App\Entity\Exercise;

class ExerciseMapper
{
    public function toDto(Exercise $exercise): ExerciseDto
    {
        return new ExerciseDto(
            id: $exercise->getId(),
            name: $exercise->getName(),
        );
    }

    public function fromDto(ExerciseDto $dto): Exercise
    {
        return new Exercise()
            ->setName($dto->name);
    }
}

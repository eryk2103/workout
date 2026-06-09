<?php

namespace App\Mapper;

use App\Dto\CreateWorkoutDto;
use App\Dto\WorkoutDto;
use App\Entity\Workout;

class WorkoutMapper
{
    public function __construct(private ExerciseMapper $exerciseMapper) {}

    public function toDto(Workout $workout, array $workoutExercises = []): WorkoutDto
    {
        return new WorkoutDto(
            id: $workout->getId(),
            name: $workout->getName(),
            exercises: array_map(
                fn($we) => $this->exerciseMapper->toDto($we->getExercise()),
                $workoutExercises,
            ),
        );
    }

    public function fromDto(CreateWorkoutDto $dto): Workout
    {
        return new Workout()
            ->setName($dto->name);
    }
}

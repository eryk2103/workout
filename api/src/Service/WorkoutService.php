<?php

namespace App\Service;

use App\Dto\CreateWorkoutDto;
use App\Dto\UpdateWorkoutDto;
use App\Entity\Workout;
use App\Entity\WorkoutExercise;
use App\Exception\ExerciseNotFoundException;
use App\Exception\WorkoutNotFoundException;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutExerciseRepository;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;

class WorkoutService
{
    public function __construct(
        private WorkoutRepository $workoutRepository,
        private EntityManagerInterface $em,
        private WorkoutExerciseRepository $weRepository,
        private ExerciseRepository $exerciseRepository,
    ) {}

    public function getAll(?string $search = null): array
    {
        $search = $search ?? '';
        return $this->workoutRepository->findByFilters($search);
    }

    public function getById(int $id): array
    {
        $workout = $this->workoutRepository->find($id);
        if($workout === null) {
            throw new WorkoutNotFoundException();
        }

        $exercises = $this->weRepository->findBy(['workout' => $workout]);

        return ['workout' => $workout, 'exercises' => $exercises];
    }

    public function create(CreateWorkoutDto $dto): Workout
    {
        $workout = new Workout();
        $workout->setName($dto->name);

        $this->em->persist($workout);

        foreach ($dto->exercisesIds as $id) {
            $exercise = $this->exerciseRepository->find($id);
            if($exercise === null) {
                throw new ExerciseNotFoundException();
            }
            $workoutExercise = new WorkoutExercise()
                ->setExercise($exercise)
                ->setWorkout($workout);

            $this->em->persist($workoutExercise);
        }
        $this->em->flush();

        return $workout;
    }

    public function update(int $id, UpdateWorkoutDto $dto): Workout
    {
        $workout = $this->workoutRepository->find($id);
        if($workout === null) {
            throw new WorkoutNotFoundException();
        }

        $workout->setName($dto->name);
        $this->em->persist($workout);

        $workoutExercises = $this->weRepository->findBy(['workout' => $workout]);
        foreach ($workoutExercises as $we) {
            $this->em->remove($we);
        }

        foreach ($dto->exercisesIds as $id) {
            $exercise = $this->exerciseRepository->find($id);
            if($exercise === null) {
                throw new ExerciseNotFoundException();
            }
            $workoutExercise = new WorkoutExercise()
                ->setExercise($exercise)
                ->setWorkout($workout);

            $this->em->persist($workoutExercise);
        }

        $this->em->flush();

        return $workout;
    }

    public function delete(int $id): void
    {
        $workout = $this->workoutRepository->find($id);
        if($workout === null) {
            throw new WorkoutNotFoundException();
        }

        $this->em->remove($workout);
        $this->em->flush();
    }
}

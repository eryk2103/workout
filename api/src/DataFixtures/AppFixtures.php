<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use App\Entity\ExerciseSession;
use App\Entity\Workout;
use App\Entity\WorkoutSession;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $exercise = new Exercise();
        $exercise->setName("Pull ups");

        $exercise2 = new Exercise()
            ->setName("Pull ups 2");

        $exercise3 = new Exercise()
            ->setName("Bench press");

        $metadata = $manager->getClassMetadata(Exercise::class);
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new AssignedGenerator());


        $reflection = new \ReflectionProperty(Exercise::class, 'id');
        $reflection->setValue($exercise, 1);
        $reflection->setValue($exercise2, 2);
        $reflection->setValue($exercise3, 3);

        $manager->persist($exercise);
        $manager->persist($exercise2);
        $manager->persist($exercise3);


        $workout = new Workout();
        $workout->setName("Push Day");

        $workout2 = new Workout()
            ->setName("Push Day 2");

        $workoutMetadata = $manager->getClassMetadata(Workout::class);
        $workoutMetadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $workoutMetadata->setIdGenerator(new AssignedGenerator());

        $workoutReflection = new \ReflectionProperty(Workout::class, 'id');
        $workoutReflection->setValue($workout, 1);
        $workoutReflection->setValue($workout2, 2);

        $manager->persist($workout);
        $manager->persist($workout2);

        $session1 = (new WorkoutSession())
            ->setWorkout($workout)
            ->setScheduledAt(new \DateTime('2026-06-10 08:00:00'));

        $session2 = (new WorkoutSession())
            ->setWorkout($workout)
            ->setScheduledAt(new \DateTime('2026-06-12 09:00:00'));

        $sessionMetadata = $manager->getClassMetadata(WorkoutSession::class);
        $sessionMetadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $sessionMetadata->setIdGenerator(new AssignedGenerator());

        $sessionReflection = new \ReflectionProperty(WorkoutSession::class, 'id');
        $sessionReflection->setValue($session1, 1);
        $sessionReflection->setValue($session2, 2);

        $manager->persist($session1);
        $manager->persist($session2);

        $exerciseSession1 = (new ExerciseSession())
            ->setExercise($exercise)
            ->setWorkoutSession($session1)
            ->setReps(10)
            ->setSet(3)
            ->setWeight(0)
            ->setScheduledAt(new \DateTime('2026-06-10 08:00:00'));

        $exerciseSession2 = (new ExerciseSession())
            ->setExercise($exercise3)
            ->setWorkoutSession($session1)
            ->setReps(8)
            ->setSet(3)
            ->setWeight(20)
            ->setScheduledAt(new \DateTime('2026-06-10 08:15:00'));

        $exerciseSession3 = (new ExerciseSession())
            ->setExercise($exercise3)
            ->setWorkoutSession(null)
            ->setReps(12)
            ->setSet(4)
            ->setWeight(60)
            ->setScheduledAt(new \DateTime('2026-06-12 09:00:00'));

        $exerciseSessionMetadata = $manager->getClassMetadata(ExerciseSession::class);
        $exerciseSessionMetadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $exerciseSessionMetadata->setIdGenerator(new AssignedGenerator());

        $exerciseSessionReflection = new \ReflectionProperty(ExerciseSession::class, 'id');
        $exerciseSessionReflection->setValue($exerciseSession1, 1);
        $exerciseSessionReflection->setValue($exerciseSession2, 2);
        $exerciseSessionReflection->setValue($exerciseSession3, 3);

        $manager->persist($exerciseSession1);
        $manager->persist($exerciseSession2);
        $manager->persist($exerciseSession3);

        $manager->flush();
    }
}

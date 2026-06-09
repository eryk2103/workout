<?php

namespace App\Entity;

use App\Repository\ExerciseSessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseSessionRepository::class)]
class ExerciseSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Exercise $exercise = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $reps = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $set = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $weight = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $scheduledAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $startAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $endAt = null;

    #[ORM\ManyToOne]
    private ?WorkoutSession $workoutSession = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    public function setExercise(?Exercise $exercise): static
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getReps(): ?int
    {
        return $this->reps;
    }

    public function setReps(?int $reps): static
    {
        $this->reps = $reps;

        return $this;
    }

    public function getSet(): ?int
    {
        return $this->set;
    }

    public function setSet(?int $set): static
    {
        $this->set = $set;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getScheduledAt(): ?\DateTime
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(?\DateTime $scheduledAt): static
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    public function getStartAt(): ?\DateTime
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTime $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTime
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTime $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getWorkoutSession(): ?WorkoutSession
    {
        return $this->workoutSession;
    }

    public function setWorkoutSession(?WorkoutSession $workoutSession): static
    {
        $this->workoutSession = $workoutSession;

        return $this;
    }
}

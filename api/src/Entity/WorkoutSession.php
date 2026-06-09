<?php

namespace App\Entity;

use App\Repository\WorkoutSessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutSessionRepository::class)]
class WorkoutSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $scheduledAt = null;

    #[ORM\ManyToOne]
    private ?Workout $workout = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScheduledAt(): ?\DateTime
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(\DateTime $scheduledAt): static
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    public function getWorkout(): ?Workout
    {
        return $this->workout;
    }

    public function setWorkout(?Workout $workout): static
    {
        $this->workout = $workout;

        return $this;
    }
}

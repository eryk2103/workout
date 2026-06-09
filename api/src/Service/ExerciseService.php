<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Exception\ExerciseNotFoundException;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;

class ExerciseService
{
    public function __construct(private ExerciseRepository $repository, private EntityManagerInterface $em) {}

    public function getAll(?string $search = null): array
    {
        $search = $search ?? '';
        return $this->repository->findByFilters($search);
    }

    public function getById(int $id): Exercise
    {
        $exercise =  $this->repository->find($id);
        if ($exercise === null) {
            throw new ExerciseNotFoundException();
        }
        return $exercise;
    }

    public function create(string $name): Exercise
    {
        $exercise = new Exercise()->setName($name);

        $this->em->persist($exercise);
        $this->em->flush();

        return $exercise;
    }

    public function update(int $id, string $name): Exercise
    {
        $exercise = $this->getById($id);
        $exercise->setName($name);

        $this->em->persist($exercise);
        $this->em->flush();

        return $exercise;
    }

    public function delete(int $id): void
    {
        $exercise = $this->getById($id);

        $this->em->remove($exercise);
        $this->em->flush();
    }
}

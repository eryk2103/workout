<?php

namespace App\Repository;

use App\Entity\Workout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workout>
 */
class WorkoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workout::class);
    }

    public function findByFilters(string $search): array
    {
        return $this->createQueryBuilder('w')
            ->andWhere('Lower(w.name) LIKE Lower(:val)')
            ->setParameter('val', '%' . $search . '%')
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}

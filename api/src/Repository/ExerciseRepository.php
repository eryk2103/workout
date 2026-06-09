<?php

namespace App\Repository;

use App\Entity\Exercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercise>
 */
class ExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }

    public function findByFilters(string $search): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('Lower(e.name) LIKE Lower(:val)')
            ->setParameter('val', '%' . $search . '%')
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}

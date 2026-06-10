<?php

namespace App\Repository;

use App\Entity\WorkoutSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkoutSession>
 */
class WorkoutSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkoutSession::class);
    }

    public function findByFilters(?\DateTime $startDate = null, ?\DateTime $endDate = null): array
    {
        $qb = $this->createQueryBuilder('ws');

        if ($startDate !== null) {
            $qb->andWhere('ws.scheduledAt >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        if ($endDate !== null) {
            $qb->andWhere('ws.scheduledAt <= :endDate')
                ->setParameter('endDate', $endDate);
        }

        return $qb->getQuery()->getResult();
    }
}

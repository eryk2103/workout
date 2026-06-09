<?php

namespace App\Tests\Integration\Repository;

use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WorkoutRepositoryTest extends KernelTestCase
{
    private WorkoutRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->repository = static::getContainer()->get(WorkoutRepository::class);
    }

    public function testFindByFiltersReturnsAllWhenSearchIsEmpty(): void
    {
        $results = $this->repository->findByFilters('');

        $this->assertNotEmpty($results);
        foreach ($results as $workout) {
            $this->assertNotNull($workout->getId());
            $this->assertNotNull($workout->getName());
        }
    }

    public function testFindByFiltersReturnsMatchingResults(): void
    {
        $results = $this->repository->findByFilters('Push');

        $this->assertNotEmpty($results);
        foreach ($results as $workout) {
            $this->assertStringContainsStringIgnoringCase('Push', $workout->getName());
        }
    }

    public function testFindByFiltersIsCaseInsensitive(): void
    {
        $upper = $this->repository->findByFilters('PUSH');
        $lower = $this->repository->findByFilters('push');

        $this->assertCount(count($upper), $lower);
    }

    public function testFindByFiltersReturnsEmptyWhenNoMatch(): void
    {
        $results = $this->repository->findByFilters('zzznonexistent');

        $this->assertIsArray($results);
        $this->assertEmpty($results);
    }

    public function testFindByFiltersRespectsMaxResults(): void
    {
        $results = $this->repository->findByFilters('');

        $this->assertLessThanOrEqual(10, count($results));
    }
}

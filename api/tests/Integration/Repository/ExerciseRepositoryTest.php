<?php

namespace App\Tests\Integration\Repository;

use App\Repository\ExerciseRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExerciseRepositoryTest extends KernelTestCase
{
    private ExerciseRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->repository = static::getContainer()->get(ExerciseRepository::class);
    }

    public function testFindByFiltersReturnsAllWhenSearchIsEmpty(): void
    {
        $results = $this->repository->findByFilters('');

        $this->assertNotEmpty($results);
        foreach ($results as $exercise) {
            $this->assertNotNull($exercise->getId());
            $this->assertNotNull($exercise->getName());
        }
    }

    public function testFindByFiltersReturnsMatchingResults(): void
    {
        $results = $this->repository->findByFilters('Pull');

        $this->assertNotEmpty($results);
        foreach ($results as $exercise) {
            $this->assertStringContainsStringIgnoringCase('Pull', $exercise->getName());
        }
    }

    public function testFindByFiltersIsCaseInsensitive(): void
    {
        $upper = $this->repository->findByFilters('PULL');
        $lower = $this->repository->findByFilters('pull');

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

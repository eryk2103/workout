<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExerciseSessionControllerTest extends WebTestCase
{
    public function testIndexSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/exercise-sessions');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('exercise', $data[0]);
        $this->assertArrayHasKey('scheduledAt', $data[0]);
    }

    public function testShowNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/exercise-sessions/99999999');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testShowSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/exercise-sessions/1');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('exercise', $data);
        $this->assertArrayHasKey('reps', $data);
        $this->assertArrayHasKey('set', $data);
        $this->assertArrayHasKey('weight', $data);
        $this->assertArrayHasKey('scheduledAt', $data);
        $this->assertArrayHasKey('workoutSession', $data);
    }

    public function testCreateSuccess(): void
    {
        $client = static::createClient();

        $payload = [
            'exerciseId' => 1,
            'scheduledAt' => '2026-06-20 08:00:00',
            'reps' => 10,
            'set' => 3,
            'weight' => 15,
            'workoutSessionId' => 1,
        ];
        $client->request('POST', '/exercise-sessions', server: ['CONTENT_TYPE' => 'application/json'], content: json_encode($payload));

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('exercise', $data);
        $this->assertArrayHasKey('scheduledAt', $data);
        $this->assertArrayHasKey('workoutSession', $data);
    }

    public function testUpdateSuccess(): void
    {
        $client = static::createClient();

        $payload = [
            'scheduledAt' => '2026-06-10 08:00:00',
            'reps' => 12,
            'set' => 4,
            'weight' => 5,
            'startAt' => '2026-06-10 08:00:00',
            'endAt' => '2026-06-10 08:30:00',
        ];
        $client->request('PUT', '/exercise-sessions/1', server: ['CONTENT_TYPE' => 'application/json'], content: json_encode($payload));

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('reps', $data);
        $this->assertArrayHasKey('set', $data);
        $this->assertArrayHasKey('weight', $data);
        $this->assertArrayHasKey('startAt', $data);
        $this->assertArrayHasKey('endAt', $data);

        $this->assertEquals(12, $data['reps']);
        $this->assertEquals(4, $data['set']);
    }

    public function testUpdateBadRequestWhenStartAtAfterEndAt(): void
    {
        $client = static::createClient();

        $payload = [
            'scheduledAt' => '2026-06-10 08:00:00',
            'startAt' => '2026-06-10 09:00:00',
            'endAt' => '2026-06-10 08:00:00',
        ];
        $client->request('PUT', '/exercise-sessions/1', server: ['CONTENT_TYPE' => 'application/json'], content: json_encode($payload));

        $this->assertResponseStatusCodeSame(400);
    }

    public function testDeleteSuccess(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/exercise-sessions/3');

        $this->assertResponseStatusCodeSame(204);
    }
}

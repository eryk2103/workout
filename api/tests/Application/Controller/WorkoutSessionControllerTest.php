<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WorkoutSessionControllerTest extends WebTestCase
{
    public function testIndexSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/workout-sessions');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('scheduledAt', $data[0]);
        $this->assertArrayHasKey('workout', $data[0]);
    }

    public function testShowNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/workout-sessions/99999999');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testShowSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/workout-sessions/1');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('workout', $data);
        $this->assertArrayHasKey('scheduledAt', $data);
    }

    public function testCreateSuccess(): void
    {
        $client = static::createClient();

        $payload = ['workoutId' => 1, 'scheduledAt' => '2026-06-20 08:00:00'];
        $client->request('POST', '/workout-sessions', server: ['CONTENT_TYPE' => 'application/json'], content: json_encode($payload));

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('scheduledAt', $data);
        $this->assertArrayHasKey('workout', $data);
    }

    public function testUpdateSuccess(): void
    {
        $client = static::createClient();

        $payload = ['scheduledAt' => '2026-06-25 10:00:00'];
        $client->request('PUT', '/workout-sessions/1', server: ['CONTENT_TYPE' => 'application/json'], content: json_encode($payload));

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('scheduledAt', $data);
        $this->assertArrayHasKey('workout', $data);
    }

    public function testDeleteSuccess(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/workout-sessions/2');

        $this->assertResponseStatusCodeSame(204);
    }
}

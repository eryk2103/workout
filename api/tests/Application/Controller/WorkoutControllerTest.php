<?php

namespace App\Tests\Application\Controller;

use App\Dto\CreateWorkoutDto;
use App\Dto\UpdateWorkoutDto;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WorkoutControllerTest extends WebTestCase
{
    public function testIndexSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/workouts');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
    }

    public function testIndexSearchFilterReturnsEmpty(): void
    {
        $client = static::createClient();
        $client->request('GET', '/workouts?search=abc');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertEmpty($data);
    }

    public function testIndexSearchFilterReturnsFiltered(): void
    {
        $client = static::createClient();
        $client->request('GET', '/workouts?search=Push');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
    }

    public function testShowNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/workouts/99999999');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testShowSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/workouts/1');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('exercises', $data);
    }

    public function testCreateSuccess(): void
    {
        $client = static::createClient();

        $newWorkout = new CreateWorkoutDto("Leg Day", [1, 3]);
        $client->request('POST', '/workouts', server: ['CONTENT_TYPE' => 'application/json'], content: json_encode($newWorkout));

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);

        $this->assertEquals($newWorkout->name, $data['name']);
    }

    public function testUpdateSuccess(): void
    {
        $client = static::createClient();
        $updatedWorkout = new UpdateWorkoutDto("Push Day Updated", [3]);

        $client->request('PUT', '/workouts/1', server: ['CONTENT_TYPE' => 'application/json'], content: json_encode($updatedWorkout));

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);

        $this->assertEquals($updatedWorkout->name, $data['name']);
    }

    public function testDeleteSuccess(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/workouts/2');

        $this->assertResponseStatusCodeSame(204);
    }
}

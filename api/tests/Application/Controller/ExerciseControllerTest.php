<?php

namespace App\Tests\Application\Controller;

use App\Dto\ExerciseDto;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExerciseControllerTest extends WebTestCase
{
    public function testIndexSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/exercises');

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
        $client->request('GET', '/exercises?search=abc');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertEmpty($data);
    }

    public function testIndexSearchFilterReturnsFiltered(): void
    {
        $client = static::createClient();
        $client->request('GET', '/exercises?search=Pull');

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
        $client->request('GET', '/exercises/99999999');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testShowSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/exercises/1');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
    }

    public function testCreateSuccess(): void
    {
        $client = static::createClient();

        $newExercise = new ExerciseDto("Push ups");
        $client->request('POST', '/exercises', server: ['CONTENT_TYPE' => 'application/json'], content: json_encode($newExercise));

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);

        $this->assertEquals($newExercise->name, $data['name']);
    }

    public function testUpdateSuccess(): void
    {
        $client = static::createClient();
        $newExercise = new ExerciseDto("Pull ups updated");

        $client->request('PUT', '/exercises/1', server: ['CONTENT_TYPE' => 'application/json'], content: json_encode($newExercise));
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);

        $this->assertEquals($newExercise->name, $data['name']);
    }

    public function testDeleteSuccess(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/exercises/2');

        $this->assertResponseStatusCodeSame(204);
    }
}

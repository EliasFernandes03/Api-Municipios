<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class PetsApiControllerTest extends TestCase
{
    private const BASE_URL = '/api/pets'; 

    public function test_the_endpoint_retrieve_a_list_of_pets(): void
    {
        $response = $this->get(self::BASE_URL);

        $content = $response->json();

        $this->assertIsArray($content);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_the_endpoint_creates_a_new_pet(): void
    {
        $response = $this->post(self::BASE_URL, [
            'name' => 'Xexeu',
            'type' => 'Cavalo',
            'weight' => 400
        ]);

        $content = json_decode($response->getContent());

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals('Xexeu', $content->name);
    }

    public function test_the_endpoint_retrieve_one_pet(): void
    {
        $response = $this->get(self::BASE_URL.'/1');

        $content = json_decode($response->getContent());

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals('Cavalo', $content->type);
        $this->assertEquals('Xexeu', $content->name);
    }

    public function test_the_endpoint_retrieve_not_found_error(): void
    {
        $response = $this->get(self::BASE_URL.'/123671');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}

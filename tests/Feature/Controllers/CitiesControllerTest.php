<?php

namespace Tests\Feature;

use Tests\TestCase;

class CitiesControllerTest extends TestCase
{
    public function test_index_returns_paginated_cities()
    {

        $response = $this->getJson('http://localhost:8080/api/cities?page=1&per_page=15&uf=CE');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',

        ]);

        $responseData = $response->json();

        $this->assertTrue($responseData['success']);
        $this->assertStringContainsString('Municípios da UF CE paginados', $responseData['message']);
        $this->assertIsArray($responseData['data']);
    }

    public function test_index_requires_uf_parameter()
    {

        $response = $this->getJson('/cities');

        $response->assertStatus(404);
        $response->assertSee('The route cities could not be found.');
    }
}

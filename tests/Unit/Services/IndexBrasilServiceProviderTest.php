<?php

namespace Tests\Unit;

use App\Services\Interfaces\IIndexBrasilServiceProvider;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IndexBrasilServiceProviderTest extends TestCase
{
    private IIndexBrasilServiceProvider $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(IIndexBrasilServiceProvider::class);
    }

    public function test_returns_cities_successfully()
    {
        $mockData = [
            ['codigo_ibge' => 1, 'nome' => 'City A'],
            ['codigo_ibge' => 2, 'nome' => 'City B'],
        ];

        Http::fake([
            'brasilapi.com.br/*' => Http::response($mockData, 200),
        ]);

        $response = $this->service->handle('RS');

        $this->assertIsArray($response);
        $this->assertTrue($response['success']);
        $this->assertEquals('Municípios carregados via BrasilAPI', $response['message']);
        $this->assertEquals($mockData, $response['data']);
    }

    public function test_returns_error_when_api_fails()
    {
        Http::fake([
            'brasilapi.com.br/*' => Http::response(null, 500),
        ]);

        $response = $this->service->handle('RS');

        $this->assertIsArray($response);
        $this->assertFalse($response['success']);
        $this->assertEquals('Erro ao consultar BrasilAPI', $response['message']);
        $this->assertEquals([], $response['data']);
    }
}

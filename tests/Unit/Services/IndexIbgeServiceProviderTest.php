<?php

namespace Tests\Unit;

use App\Services\Interfaces\IIndexIbgeServiceProvider;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IndexIbgeServiceProviderTest extends TestCase
{
    private IIndexIbgeServiceProvider $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(IIndexIbgeServiceProvider::class);
    }

    public function test_returns_municipios_successfully()
    {
        $mockData = [
            ['id' => 1, 'nome' => 'São Paulo'],
            ['id' => 2, 'nome' => 'Campinas'],
        ];

        config()->set('services.ibgeapi.ibge_url', 'https://ibgeapi.test');

        Http::fake([
            'https://ibgeapi.test/SP/municipios' => Http::response($mockData, 200),
        ]);

        $response = $this->service->handle('SP');

        $this->assertIsArray($response);
        $this->assertTrue($response['success']);
        $this->assertEquals('Municípios carregados via IBGE API', $response['message']);
        $this->assertEquals($mockData, $response['data']);
    }

    public function test_returns_error_when_api_fails()
    {
        config()->set('services.ibgeapi.ibge_url', 'https://ibgeapi.test');

        Http::fake([
            'https://ibgeapi.test/XX/municipios' => Http::response(null, 500),
        ]);

        $response = $this->service->handle('XX');

        $this->assertIsArray($response);
        $this->assertFalse($response['success']);
        $this->assertEquals('Erro ao consultar IBGE API', $response['message']);
        $this->assertEquals([], $response['data']);
    }
}

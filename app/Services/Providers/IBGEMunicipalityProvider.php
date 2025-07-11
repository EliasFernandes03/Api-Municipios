<?php

declare(strict_types=1);

namespace App\Services\Providers;

use App\Collections\CitiesCollection;
use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\MunicipalityProviderInterface;
use App\Support\ApiReturn;

class IBGEMunicipalityProvider implements MunicipalityProviderInterface
{
    public function getMunicipalitiesByUf(string $uf): array
    {
        $urlBase = config('services.ibge.municipios_url');
        $url = $urlBase . '/' . strtolower($uf) . '/municipios';
        $response = Http::get($url);

        if ($response->failed()) {
            return ApiReturn::error('Erro ao consultar BrasilAPI');
        }

        $collection = new CitiesCollection($response->json());

        $municipios = $collection->format();

        return ApiReturn::success($municipios, 'Municípios carregados via IBGE');
    }
}

<?php

declare(strict_types=1);

namespace App\Services\Providers;

use App\Collections\CitiesCollection;
use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\MunicipalityProviderInterface;
use App\Support\ApiReturn;

class BrasilApiMunicipalityProvider implements MunicipalityProviderInterface
{
    public function getMunicipalitiesByUf(string $uf): array
    {
        $urlBase = config('services.brasilapi.municipios_url');
        $url = $urlBase . '/' . strtoupper($uf);
        $response = Http::get($url);

        if ($response->failed()) {
            return ApiReturn::error('Erro ao consultar BrasilAPI');
        }

        $municipios = (new CitiesCollection($response->json()))->format();

        return ApiReturn::success($municipios, 'Municípios carregados via BrasilAPI');
    }
}

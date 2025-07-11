<?php

declare(strict_types=1);

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\MunicipalityProviderInterface;

class BrasilApiMunicipalityProvider implements MunicipalityProviderInterface
{
    public function getMunicipalitiesByUf(string $uf): array
    {
        $url = "https://brasilapi.com.br/api/ibge/municipios/v1/" . strtoupper($uf);
        $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception("Erro ao consultar BrasilAPI");
        }

        return collect($response->json())->map(function ($item) {
            return [
                'name' => $item['nome'],
                'ibge_code' => $item['codigo_ibge']
            ];
        })->toArray();
    }
}

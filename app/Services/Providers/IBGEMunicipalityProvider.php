<?php

declare(strict_types=1);

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\MunicipalityProviderInterface;

class IBGEMunicipalityProvider implements MunicipalityProviderInterface
{
    public function getMunicipalitiesByUf(string $uf): array
    {
        $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" . strtolower($uf) . "/municipios";
        $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception("Erro ao consultar IBGE");
        }

        return collect($response->json())->map(function ($item) {
            return [
                'name' => $item['nome'],
                'ibge_code' => $item['id']
            ];
        })->toArray();
    }
}

<?php

declare(strict_types=1);

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\IIndexBrasilServiceProvider;
use App\Support\ApiReturn;

class IndexIbgeServiceProvider implements IIndexBrasilServiceProvider
{
    public function handle(string $uf): array
    {
        $urlBase = config('services.brasilapi.ibge_url');

        $url = $urlBase . '/' . ($uf) . "/municipios";
        $response = Http::get($url);

        if ($response->failed()) {
            return ApiReturn::error('Erro ao consultar IBGE API');
        }


        return ApiReturn::success($response->json(), 'Municípios carregados via IBGE API');
    }
}

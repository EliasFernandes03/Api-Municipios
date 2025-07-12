<?php

declare(strict_types=1);

namespace App\Services\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\IIndexIbgeServiceProvider;
use App\Support\ApiReturn;

class IndexIbgeServiceProvider implements IIndexIbgeServiceProvider
{
    public function handle(string $uf): array
    {
        $urlBase = config('services.ibgeapi.ibge_url');

        $url = $urlBase . '/' . ($uf) . "/municipios";
        $response = Http::get($url);

        if ($response->failed()) {
            return ApiReturn::error('Erro ao consultar IBGE API');
        }

        return ApiReturn::success($response->json(), 'Municípios carregados via IBGE API');
    }
}

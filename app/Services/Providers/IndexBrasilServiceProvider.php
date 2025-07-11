<?php

declare(strict_types=1);

namespace App\Services\Providers;

use App\Collections\IndexCitiesCollection;
use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\IIndexBrasilServiceProvider;
use App\Support\ApiReturn;

class IndexBrasilServiceProvider implements IIndexBrasilServiceProvider
{
    public function handle(string $uf): array
    {
        $urlBase = config('services.brasilapi.municipios_url');

        $url = $urlBase . '/' . ($uf);
        $response = Http::get($url);

        if ($response->failed()) {
            return ApiReturn::error('Erro ao consultar BrasilAPI');
        }


        return ApiReturn::success($response->json(), 'Municípios carregados via BrasilAPI');
    }
}

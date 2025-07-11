<?php

declare(strict_types=1);

namespace App\Services\CitiesService;

use App\Services\Interfaces\IIndexBrasilServiceProvider;
use Illuminate\Support\Facades\Cache;
class IndexCitiesService
{
    public function __construct(private IIndexBrasilServiceProvider $brasilServiceProvider)
    {
    }
    public function handle(string $uf): array
    {
        $cacheKey = "cities_{$uf}";
        $cacheTTL = config('services.cache.cities_ttl'); 

        return Cache::store('file')->remember($cacheKey, $cacheTTL, function () use ($uf) {
            return $this->brasilServiceProvider->handle($uf);
        });
    }
}
<?php

declare(strict_types=1);

namespace App\Services\CitiesService;

use App\Services\Interfaces\IIndexBrasilServiceProvider;
use Illuminate\Support\Facades\Cache;

class IndexCitiesService
{
    private string $uf = 'RS'; 
    private int $cacheTtl;
    private string $cacheDriver = 'file';

    public function __construct(private IIndexBrasilServiceProvider $brasilServiceProvider)
    {
        $this->cacheTtl = config('services.cache.cities_ttl', 3600); 
    }

    public function setUf(string $uf): self
    {
        $this->uf = strtoupper($uf);
        return $this;
    }

    public function setCacheTtl(int $ttl): self
    {
        $this->cacheTtl = $ttl;
        return $this;
    }

    public function setCacheDriver(string $driver): self
    {
        $this->cacheDriver = $driver;
        return $this;
    }

    public function handle(): array
    {
        $cacheKey = "cities_{$this->uf}";

        return Cache::store($this->cacheDriver)->remember(
            $cacheKey,
            $this->cacheTtl,
            fn () => $this->brasilServiceProvider->handle($this->uf)
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Services\CitiesService;

use App\Collections\IndexCitiesCollection ;

use App\Services\Interfaces\IIndexBrasilServiceProvider;
use Illuminate\Support\Facades\Cache;

class IndexCitiesService
{
    private string $uf = 'RS'; 
    private int $cacheTtl;
    private string $cacheDriver = 'file';

    private int $page = 1;
    private int $perPage = 15;

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

    public function setPage(int $page): self
    {
        $this->page =  $page;
        return $this;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;
        return $this;
    }
    public function handle(): IndexCitiesCollection
    {
        // Chamada direta, sem cache
        $allCities = $this->brasilServiceProvider->handle($this->uf);

        $citiesData = $allCities['data'] ?? [];
        dd($citiesData);
        $total = count($citiesData);
        $offset = ($this->page - 1) * $this->perPage;

        $paginated = array_slice($citiesData, $offset, $this->perPage);

        return new IndexCitiesCollection($paginated, $total, $this->page, $this->perPage);
    }
}

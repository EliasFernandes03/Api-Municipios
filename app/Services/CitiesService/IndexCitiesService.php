<?php

declare(strict_types=1);

namespace App\Services\CitiesService;

use App\Collections\IndexCitiesCollection;
use App\Services\Interfaces\IIndexBrasilServiceProvider;
use App\Services\Interfaces\IIndexCitiesService;
use App\Services\Interfaces\IIndexIbgeServiceProvider;
use Illuminate\Support\Facades\Cache;

class IndexCitiesService implements IIndexCitiesService
{
    private string $uf;

    private int $cacheTtl;

    private string $cacheDriver = 'file';

    private int $page;

    private int $perPage;

    public function __construct(
        private readonly IIndexBrasilServiceProvider $indexBrasilServiceProvider,
        private readonly IIndexIbgeServiceProvider $indexIbgeServiceProvider
    ) {}

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
        $this->page = $page;

        return $this;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function handle(): IndexCitiesCollection
    {
      $cacheKey = "cities_{$this->uf}";

      $allCities = Cache::store($this->cacheDriver)->remember(
            $cacheKey,
            $this->cacheTtl,
            function () {
                $brasilData = $this->indexBrasilServiceProvider->handle($this->uf);
                return $brasilData ?? $this->indexIbgeServiceProvider->handle($this->uf);
            }
        );

        $citiesData = $allCities['data'] ?? [];

        $total = count($citiesData);
        $offset = ($this->page - 1) * $this->perPage;

        $paginated = array_slice($citiesData, $offset, $this->perPage);

        return new IndexCitiesCollection($paginated, $total, $this->page, $this->perPage);
    }
}

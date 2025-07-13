<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Collections\IndexCitiesCollection;

interface IIndexCitiesService
{
    public function setUf(string $uf): self;

    public function setCacheTtl(int $ttl): self;

    public function setCacheDriver(string $driver): self;

    public function setPage(?int $page): self;

    public function setPerPage(?int $perPage): self;

    public function handle(): IndexCitiesCollection;
}

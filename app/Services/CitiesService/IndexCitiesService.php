<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\IIndexBrasilServiceProvider;
use Illuminate\Support\Facades\Cache;

class MunicipalityService
{
    public function __construct(
        protected IIndexBrasilServiceProvider $provider
    ) {}

    public function getByUf(string $uf): array
    {
        return Cache::remember("municipios_{$uf}", now()->addHours(1), function () use ($uf) {
            return $this->provider->handle($uf);
        });
    }
}

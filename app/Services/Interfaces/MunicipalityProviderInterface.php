<?php

declare(strict_types=1);


namespace App\Services\Interfaces;

interface MunicipalityProviderInterface
{
    public function getMunicipalitiesByUf(string $uf): array;
}
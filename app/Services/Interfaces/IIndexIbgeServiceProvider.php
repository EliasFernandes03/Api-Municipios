<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface IIndexIbgeServiceProvider
{
    public function handle(string $uf): array;
}

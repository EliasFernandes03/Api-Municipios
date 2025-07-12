<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface IIndexBrasilServiceProvider
{
    public function handle(string $uf): array;
}

<?php

declare(strict_types=1);

namespace App\Collections;

use Illuminate\Support\Collection;

class CitiesCollection extends Collection
{
    public function format(): array
    {
        return $this->map(function ($item) {
            return [
                'nome' => $item['nome'] ?? null,
                'codigo_ibge' => $item['codigo_ibge'] ?? null,
            ];
        })->toArray();
    }
}

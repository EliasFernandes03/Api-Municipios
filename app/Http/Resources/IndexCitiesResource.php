<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexCitiesResource extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'success' => true,
            'message' => "Municípios da UF {$request->input('uf')} paginados",
            'data' => IndexCitiesResource::collection($this->collection),
            'meta' => [
                'total' => $this->additional['total'] ?? 0,
                'page' => $this->additional['page'] ?? 1,
                'per_page' => $this->additional['per_page'] ?? 15,
                'last_page' => $this->additional['last_page'] ?? 1,
            ]
        ];
    }
}

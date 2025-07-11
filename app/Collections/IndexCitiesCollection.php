<?php

declare(strict_types=1);

namespace App\Collections;

class IndexCitiesCollection
{
    private array $data;
    private int $total;
    private int $page;
    private int $perPage;
    private int $lastPage;

    public function __construct(array $data, int $total, int $page, int $perPage)
    {
        $this->data = $data;
        $this->total = $total;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->lastPage = (int) ceil($total / $perPage);
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'meta' => [
                'total' => $this->total,
                'page' => $this->page,
                'per_page' => $this->perPage,
                'last_page' => $this->lastPage,
            ],
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CitiesService\IndexCitiesService;
use Illuminate\Http\JsonResponse;

class CitiesController extends Controller
{
  public function __construct(private IndexCitiesService $indexCitiesService) {}

    public function index(): JsonResponse
    {
        try {

            $data = $this->indexCitiesService->handle('RS');
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar municípios'], 500);
        }
    }
}
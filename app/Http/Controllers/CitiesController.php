<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\IndexCitiesRequest;
use App\Services\CitiesService\IndexCitiesService;
use Illuminate\Http\JsonResponse;

class CitiesController extends Controller
{
    public function __construct(private IndexCitiesService $indexCitiesService) {}

    public function index(IndexCitiesRequest $request): JsonResponse
    {
        try {
            $uf = $request->input('uf', 'RS');
            $page = (int) $request->input('page', 1);
            $perPage = (int) $request->input('per_page', 15);

            $allCities = $this->indexCitiesService
                ->setUf($uf)
                ->setCacheTtl(3600) 
                ->handle();

            $total = count($allCities['data'] ?? []);
            $offset = ($page - 1) * $perPage;
            $paginated = array_slice($allCities['data'] ?? [], $offset, $perPage);

            return response()->json([
                'success' => true,
                'message' => "Municípios da UF {$uf} paginados",
                'data' => $paginated,
                'meta' => [
                    'total' => $total,
                    'page' => $page,
                    'per_page' => $perPage,
                    'last_page' => ceil($total / $perPage),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar municípios'], 500);
        }
    }
}

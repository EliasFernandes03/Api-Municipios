<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\IndexCitiesRequest;
use App\Services\CitiesService\IndexCitiesService;
use Illuminate\Http\JsonResponse;

class CitiesController extends Controller
{

    public function index(IndexCitiesRequest $request, IndexCitiesService $indexCitiesService): JsonResponse
    {

        $uf = $request->input('uf');

        $collection = $indexCitiesService
            ->setUf($uf)
            ->setCacheTtl(1)
            ->setPage((int) $request->input('page', 1))
            ->setPerPage((int) $request->input('per_page', 15))
            ->handle();

        return response()->json([
            'success' => true,
            'message' => "Municípios da UF {$uf} paginados",
            ...$collection->toArray(),
        ]);
    }



}

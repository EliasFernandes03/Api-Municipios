<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Interfaces\IIndexBrasilServiceProvider;

class CitiesController extends Controller
{
    public function __construct(private IIndexBrasilServiceProvider $municipalityProvider) {}

    public function index()
    {
        try {
            $data = $this->municipalityProvider->handle('RS');
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar municípios'], 500);
        }
    }
}
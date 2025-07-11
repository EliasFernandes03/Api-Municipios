<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Interfaces\MunicipalityProviderInterface;

class CitiesController extends Controller
{
    public function __construct(private MunicipalityProviderInterface $municipalityProvider) {}

    public function index()
    {
        try {
            $data = $this->municipalityProvider->getMunicipalitiesByUf('RS');
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar municípios'], 500);
        }
    }
}
<?php

namespace App\Providers;

use App\Services\Interfaces\IIndexBrasilServiceProvider;
use App\Services\Providers\IndexBrasilServiceProvider;
use App\Services\Providers\IBGEMunicipalityProvider;
use Illuminate\Support\ServiceProvider;

class CitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IIndexBrasilServiceProvider::class, function () {
            $provider = config('services.municipality_provider');

            return match ($provider) {
                'brasilapi' => new IndexBrasilServiceProvider(),
                'ibge' => new IBGEMunicipalityProvider(),
                default => throw new \Exception("Provider inválido"),
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Services\Interfaces\MunicipalityProviderInterface;
use App\Services\Providers\BrasilApiMunicipalityProvider;
use App\Services\Providers\IBGEMunicipalityProvider;
use Illuminate\Support\ServiceProvider;

class MunicipalityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MunicipalityProviderInterface::class, function () {
            $provider = config('services.municipality_provider');

            return match ($provider) {
                'brasilapi' => new BrasilApiMunicipalityProvider(),
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

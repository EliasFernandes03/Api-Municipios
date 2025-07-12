<?php

namespace App\Providers;

use App\Services\Interfaces\IIndexBrasilServiceProvider;
use App\Services\Interfaces\IIndexIbgeServiceProvider;
use App\Services\Providers\IndexBrasilServiceProvider;

use App\Services\Providers\IndexIbgeServiceProvider;
use Illuminate\Support\ServiceProvider;

class CitiesServiceProvider extends ServiceProvider
{

   public function register(): void
    {

        $this->app->bind(IIndexBrasilServiceProvider::class, function () {
            return new IndexBrasilServiceProvider();
        });


        $this->app->bind(IIndexIbgeServiceProvider::class, function () {
            return new IndexIbgeServiceProvider();
        });
    }
    public function boot(): void
    {
        //
    }
}

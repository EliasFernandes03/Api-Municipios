<?php

use Illuminate\Support\Facades\Route;

Route::get('/cities', [\App\Http\Controllers\CitiesController::class, 'index']);

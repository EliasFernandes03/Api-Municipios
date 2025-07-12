<?php

use Illuminate\Support\Facades\Route;

Route::get('/consulta-municipios', function () {
    return view('cities');
});

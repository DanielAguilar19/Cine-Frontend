<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/asientos/{eventoId}', [AsientoController::class, 'showAsientos']);

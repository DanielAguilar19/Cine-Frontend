<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/funciones/{id}/asientos', [AsientoController::class, 'showAsientos'])->name('asientos.show');
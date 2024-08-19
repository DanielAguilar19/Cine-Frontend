<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeliculaController;

Route::get('/asientos/{codigoSala}', [AsientoController::class, 'showAsientos']);

Route::patch('/asientos/actualizar/{codigoAsiento}', [AsientoController::class, 'actualizarEstadoAsiento']);

Route::get('/', function(){return view('login');});

Route::get('/registro', function() {return view('registro');});

Route::post('/salvarContacto', [LoginController::class, 'salvarCliente'])->name('guardarCliente');

Route::get('/peliculas', [PeliculaController::class, 'index']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PeliculaDetalleController;

Route::get('/', function(){return view('login');});

Route::get('/registro', function() {return view('registro');});

Route::post('/salvarContacto', [LoginController::class, 'salvarCliente'])->name('guardarCliente');

Route::get('/peliculas', [PeliculaController::class, 'index'])->name('peliculas');
    
Route::get('/asientos/{codigoSala}', [AsientoController::class, 'showAsientos']);

Route::patch('/asientos/actualizar/{codigoAsiento}', [AsientoController::class, 'actualizarEstadoAsiento']);

Route::post('/factura', [FacturaController::class, 'store'])->name('factura.store');

Route::get('/detalle', [PeliculaDetalleController::class, 'index']);

Route::get('/evento/{titulo}', [PeliculaDetalleController::class, 'show']);
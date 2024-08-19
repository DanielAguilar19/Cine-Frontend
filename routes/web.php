<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PeliculaDetalleController;
use App\Http\Controllers\MetodoPagoController;

Route::get('/', function(){return view('login');});

Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/registro', function() {return view('registro');});

/* //No funciona
Route::post('/salvarContacto', [LoginController::class, 'salvarCliente'])->name('guardarCliente');
// */
Route::get('/peliculas', [PeliculaController::class, 'index'])->name('peliculas');

Route::get('/evento/{titulo}', [PeliculaDetalleController::class, 'show'])->name('evento.show');
    
Route::get('/facturacion/{evento_id}', [FacturaController::class, 'create'])->name('facturacion');

Route::get('/asientos/{codigoSala}', [AsientoController::class, 'showAsientos'])->name('asientos');

Route::get('/metodoPago', [MetodoPagoController::class, 'index'])->name('pago.index');

// RUTAS FUNCIONANDO CORRECTAMENTE
Route::patch('/asientos/actualizar/{codigoAsiento}', [AsientoController::class, 'actualizarEstadoAsiento']);

Route::post('/factura/store', [FacturaController::class, 'storeFactura'])->name('factura.store');

Route::get('/detalle', [PeliculaDetalleController::class, 'index']);

// Guardar cliente
Route::post('/guardar-cliente', [LoginController::class, 'salvarCliente'])->name('guardarCliente');

// Iniciar sesión
Route::post('/login', [LoginController::class, 'login'])->name('login');

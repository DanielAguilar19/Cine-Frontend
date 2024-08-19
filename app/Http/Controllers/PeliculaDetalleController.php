<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Pelicula;
use App\Models\Sala;

class PeliculaDetalleController extends Controller
{
    public function show($titulo)
    {
        // Obtener el evento por título
        $evento = Evento::with('pelicula', 'sala')->whereHas('pelicula', function($query) use ($titulo) {
            $query->where('titulo', $titulo);
        })->firstOrFail();

        $pelicula = $evento->pelicula;
        $sala = $evento->sala;

        return view('detalle_evento', compact('evento', 'pelicula', 'sala'));
    }
}

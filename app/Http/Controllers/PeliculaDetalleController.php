<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Evento;
use App\Models\Pelicula;
use App\Models\Sala;
use App\Models\Horario;

class PeliculaDetalleController extends Controller
{
    public function show($titulo)
    {
        // api del evento

        $response = Http::get('https://api.example.com/evento/obtenerPorNombre', [
            'titulo' => $titulo
        ]);

        if ($response->failed()) {
            abort(404, 'Evento no encontrado');
        }

        $evento = $response->json();

        // pelicula salas horario etc.

        $pelicula = Pelicula::find($evento['codigo_pelicula']);
        $salas = Sala::whereIn('id', $evento['salas'])->get();
        $horarios = Horario::whereIn('id', $evento['horarios'])->get();

        return view('detalle_evento', compact('evento', 'pelicula', 'salas', 'horarios'));
    }
}

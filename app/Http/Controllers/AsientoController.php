<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AsientoController extends Controller
{
    public function showAsientos($eventoId)
{
    $disponibleAsientosResponse = Http::get("http://localhost:8080/api/asientoevento/libres/{$eventoId}");
    $disponibleAsientos = $disponibleAsientosResponse->json();

    $ocupadoAsientosResponse = Http::get("http://localhost:8080/api/asientoevento/ocupados/{$eventoId}");
    $ocupadoAsientos = $ocupadoAsientosResponse->json();

    return view('Asientos', [
        'disponibleAsientos' => $disponibleAsientos,
        'ocupadoAsientos' => $ocupadoAsientos,
    ]);
}
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AsientoController extends Controller
{
    public function showAsientos($eventoId)
    {

        $disponibleAsientosResponse = Http::get("http://your-java-backend/api/asientos/libres/{$eventoId}");
        $disponibleAsientos = $disponibleAsientosResponse->json();

        $ocupadoAsientosResponse = Http::get("http://your-java-backend/api/asientos/ocupados/{$eventoId}");
        $ocupadoAsientos = $ocupadoAsientosResponse->json();

        return view('asientos.index', [
            'disponibleAsientos' => $disponibleAsientos,
            'ocupadoAsientos' => $ocupadoAsientos,
        ]);
    }
}

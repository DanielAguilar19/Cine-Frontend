<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los datos enviados desde la selección de asientos
        $tituloPelicula = $request->get('titulo');
        $cantidadBoletos = $request->get('cantidadBoletos');
        $asientosSeleccionados = $request->get('codigoAsientos');

        // Convertir los asientos seleccionados en array si es necesario
        if (!is_array($asientosSeleccionados)) {
            $asientosSeleccionados = explode(',', $asientosSeleccionados);
        }

        // Obtener los detalles de la película y la sala basados en el título de la película
        $response = Http::get("http://localhost:8080/api/evento/obtenerPorNombre", [
            'titulo' => $tituloPelicula,
        ]);

        $evento = $response->json()[0] ?? null;

        // Si la respuesta tiene datos válidos
        if ($evento) {
            $pelicula = $evento['pelicula']['titulo'] ?? 'No disponible';
            $sala = $evento['sala']['tipoSala']['descripcion'] ?? 'No disponible';
            $precioBoleto = $evento['sala']['tipoSala']['precio'] ?? 0;
        } else {
            $pelicula = 'No disponible';
            $sala = 'No disponible';
            $precioBoleto = 0;
        }

        // Calcular el total a pagar
        $total = $precioBoleto * $cantidadBoletos;

        // Muestra la vista con los datos
        return view('metodoPago', compact('pelicula', 'sala', 'asientosSeleccionados', 'cantidadBoletos', 'total'));
    }
}

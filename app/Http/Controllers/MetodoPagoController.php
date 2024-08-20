<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MetodoPagoController extends Controller
{
    public function index(Request $request)
    {
        $codigoEvento = $request->get('codigoEvento');
        $cantidadBoletos = $request->get('cantidadBoletos');
        $asientosSeleccionados = $request->get('codigoAsientos');
        $total = $request->get('total'); 

        if (!$codigoEvento || !$cantidadBoletos || !$asientosSeleccionados) {
            return redirect()->back()->withErrors(['error' => 'Faltan datos para continuar con el pago.']);
        }

        if (!is_array($asientosSeleccionados)) {
            $asientosSeleccionados = explode(',', $asientosSeleccionados);
        }

        if (!$total) {
            try {
                $response = Http::get("http://localhost:8080/api/evento/obtenerPorNombre", [
                    'titulo' => $request->get('titulo'), 
                ]);

                $evento = $response->json()[0] ?? null;

                if ($evento) {
                    $pelicula = $evento['pelicula']['titulo'] ?? 'No disponible';
                    $sala = $evento['sala']['tipoSala']['descripcion'] ?? 'No disponible';
                    $precioBoleto = $evento['sala']['tipoSala']['precio'] ?? 0;
                } else {
                    $pelicula = 'No disponible';
                    $sala = 'No disponible';
                    $precioBoleto = 0;
                }

                $total = $precioBoleto * $cantidadBoletos;

            } catch (\Exception $e) {
                Log::error('Error en el controlador MetodoPagoController: ' . $e->getMessage());
                return redirect()->back()->withErrors(['api_error' => 'Ocurrió un error inesperado. Inténtalo nuevamente.']);
            }
        }

        return view('metodoPago', compact('total', 'pelicula', 'sala', 'asientosSeleccionados', 'cantidadBoletos'));
    }
}

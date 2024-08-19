<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MetodoPagoController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los datos enviados desde la selección de asientos
        $codigoEvento = $request->get('codigoEvento');
        $cantidadBoletos = $request->get('cantidadBoletos');
        $asientosSeleccionados = $request->get('codigoAsientos');
        $total = $request->get('total'); // Recibir el total calculado si está disponible

        // Verificar si los datos son correctos
        if (!$codigoEvento || !$cantidadBoletos || !$asientosSeleccionados) {
            return redirect()->back()->withErrors(['error' => 'Faltan datos para continuar con el pago.']);
        }

        // Convertir los asientos seleccionados en array si es necesario
        if (!is_array($asientosSeleccionados)) {
            $asientosSeleccionados = explode(',', $asientosSeleccionados);
        }

        // Si no se recibe el total, realizar el cálculo
        if (!$total) {
            try {
                // Llamada a la API para obtener los detalles del evento
                $response = Http::get("http://localhost:8080/api/evento/obtenerPorNombre", [
                    'titulo' => $request->get('titulo'), // Aquí asegúrate de enviar el título correcto
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

            } catch (\Exception $e) {
                Log::error('Error en el controlador MetodoPagoController: ' . $e->getMessage());
                return redirect()->back()->withErrors(['api_error' => 'Ocurrió un error inesperado. Inténtalo nuevamente.']);
            }
        }

        // Muestra la vista con los datos, incluyendo el total
        return view('metodoPago', compact('total', 'pelicula', 'sala', 'asientosSeleccionados', 'cantidadBoletos'));
    }
}

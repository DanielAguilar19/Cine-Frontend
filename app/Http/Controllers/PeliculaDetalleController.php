<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PeliculaDetalleController extends Controller
{
    public function show($titulo){
    $client = new Client();

        try {
            // Realizar la solicitud GET a la API para obtener el evento por título
            $response = $client->get('http://localhost:8080/api/evento/obtenerPorNombre', [
                'query' => [
                    'titulo' => $titulo
                ],
                'headers' => ['Accept' => 'application/json'],
            ]);
        
            $eventos = json_decode($response->getBody(), true);
        
            // Tomar el primer evento de la respuesta
            if (!empty($eventos) && isset($eventos[0])) {
                $evento = $eventos[0];
                $pelicula = $evento['pelicula'];
                $sala = $evento['sala'];
                $horarios = [$evento];  // Si sólo hay un horario en el evento, lo ponemos en un array
            } else {
                return redirect()->back()->withErrors(['error' => 'Evento no encontrado']);
            }
        
            return view('PeliculaDetalle', compact('evento', 'pelicula', 'sala', 'horarios'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['api_error' => 'Error al conectar con el servicio. Inténtalo nuevamente.']);
        }
    }

    
}

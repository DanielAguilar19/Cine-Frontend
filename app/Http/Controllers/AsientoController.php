<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class AsientoController extends Controller
{   
    public function showAsientos($codigoSala) {
        // Fetch all seats for the given sala
        $asientosSalaResponse = Http::get("http://localhost:8080/api/asientos/obtenerporsala/{$codigoSala}");
        $asientosSala = $asientosSalaResponse->json();
    
        // Loop through each asiento and check its availability
        foreach ($asientosSala as &$asiento) {
            // Set a default CSS class (optional, but helps avoid errors)
            $asiento['cssClass'] = 'unknown'; // Default class
    
            // Call the disponibilidad API for each asiento
            $disponibilidadResponse = Http::post("http://localhost:8080/api/asientoevento/obtener/disponibilidad/", [
                'codigoAsiento' => $asiento['codigoAsiento'],
            ]);
    
            // Check if the API call was successful and returned a valid response
            $disponibilidad = $disponibilidadResponse->json();

            if ($disponibilidad === true) {
                $asiento['cssClass'] = 'available';
            } else if ($disponibilidad === false) {
                $asiento['cssClass'] = 'unavailable';
            } else {
                $asiento['cssClass'] = 'unknown'; // Optional for debugging
            }
        }
    
        return view('Asientos', [
            'asientos' => $asientosSala,
        ]);
    }
    

    public function actualizarEstadoAsiento($codigoAsiento)
    {
        $client = new Client();
        $response = $client->patch("http://localhost:8080/api/asientos/{$codigoAsiento}", [
            'json' => ['disponible' => 0],
        ]);
        if ($response->getStatusCode() === 200) {
            return response()->json(['message' => 'Asiento actualizado con éxito'], 200);
        } else {
            return response()->json(['message' => 'Error al actualizar el asiento'], 500);
        }
    }
}


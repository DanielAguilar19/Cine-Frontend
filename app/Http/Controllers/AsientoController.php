<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AsientoController extends Controller
{   
    public function showAsientos(Request $request, $codigoSala) {
        $cantidadBoletos = $request->input('cantidadBoletos');
        $codigoEvento = $request->input('codigoEvento');
    
        // obtener asientos por sala
        $asientosSalaResponse = Http::get("http://localhost:8080/api/asientos/obtenerporsala/{$codigoSala}");
        $asientosSala = $asientosSalaResponse->json();
    
        // loop para ver disponibilidad
        foreach ($asientosSala as &$asiento) {
            $asiento['cssClass'] = 'unknown'; 
    
            $disponibilidadResponse = Http::post("http://localhost:8080/api/asientoevento/obtener/disponibilidad/", [
                'codigoAsiento' => $asiento['codigoAsiento'],
            ]);
    
            $disponibilidad = $disponibilidadResponse->json();
    
            if ($disponibilidad === true) {
                $asiento['cssClass'] = 'available';
            } else if ($disponibilidad === false) {
                $asiento['cssClass'] = 'unavailable';
            } else {
                $asiento['cssClass'] = 'unknown'; 
            }
        }
    
        return view('Asientos', [
            'asientos' => $asientosSala,
            'cantidadBoletos' => $cantidadBoletos,
            'codigoEvento' => $codigoEvento,
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


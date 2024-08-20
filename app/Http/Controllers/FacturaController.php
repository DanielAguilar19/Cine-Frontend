<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class FacturaController extends Controller
{
    public function storeFactura(Request $req) {
        dd($req->all()); 
        $cliente = Session::get('user');
        if (!$cliente) {
            return redirect('/login')->withErrors(['login_required' => 'Por favor, inicie sesión para continuar.']);
        }
    
        dd($req->all());
    
        $codigoEvento = $req->input('codigoEvento');
        $cantidadBoletos = $req->input('cantidadBoletos');
    
        if (!$codigoEvento || !$cantidadBoletos) {
            return redirect()->back()->withErrors(['error' => 'Código de evento o cantidad de boletos faltante']);
        }
    
        $client = new \GuzzleHttp\Client();
    
        try {
            $response = $client->get("http://localhost:8080/api/evento/{$codigoEvento}");
            dd($response);
            Log::info($response->getBody()->getContents());
    
            if ($response->getStatusCode() != 200) {
                return redirect()->back()->withErrors(['api_error' => 'No se pudo obtener los detalles del evento']);
            }
    
            $eventoData = json_decode($response->getBody()->getContents(), true);
            dd($eventoData); 

            if (!$eventoData || !isset($eventoData['sala']['tipoSala']['precio'])) {
                return redirect()->back()->withErrors(['api_error' => 'Detalles del evento no disponibles']);
            }
    
            $precioPorBoleto = $eventoData['sala']['tipoSala']['precio'];
            $total = $precioPorBoleto * $cantidadBoletos;
    
            $detalleFacturaData = [
                'codigoCliente' => $cliente['codigoCliente'],
                'codigoEvento' => $codigoEvento,
                'cantidadBoletos' => $cantidadBoletos,
                'numeroTarjeta' => $req->input('numeroTarjeta'),
            ];
    
            Log::info('Datos enviados a la API de detalle de factura:', $detalleFacturaData);
    
            $response = $client->post('http://localhost:8080/api/detallefactura/crear', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $detalleFacturaData,
            ]);
    
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            Log::info('Estado de respuesta:', ['status' => $statusCode, 'body' => $body]);
    
            if ($statusCode == 200) {
                return redirect('/')->with('success', 'Pago realizado exitosamente');
            } else {
                return redirect()->back()->withErrors(['api_error' => 'Error al realizar el pago: ' . $body]);
            }
        } catch (\Exception $e) {
            Log::error('Error al conectar con la API de facturación: ' . $e->getMessage());
            return redirect()->back()->withErrors(['api_error' => 'Error al conectar con el servicio de facturación. Inténtalo nuevamente.']);
        }
    }
    
}

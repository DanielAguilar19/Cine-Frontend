<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request){
        if ($request->isMethod('post')) {
            $client = new Client();
            try {
                $response = $client->get('http://localhost:8080/api/cliente/obtenerPorCorreo', [
                    'query' => [
                        'correo' => $request->input('correo'), 
                        'contrasenia' => $request->input('contrasenia'),
                    ],
                    'headers' => ['Accept' => 'application/json'],
                ]);
                $user = json_decode($response->getBody(), true);
                if (!empty($user) && isset($user['codigoCliente'])) {
                    Session::put('user', $user);
                    return redirect()->route('peliculas');
                }
                return back()->withErrors(['correo' => 'Correo o contraseña incorrecta']);
            } catch (\Exception $e) {
                Log::error('Error al conectar con la API: ' . $e->getMessage());
                return back()->withErrors(['api_error' => 'Error al conectar con el servicio. Inténtalo nuevamente.']);
            }
        }
        return redirect('/');
    }

    public function salvarCliente(Request $req) {
        $validatedData = $req->validate([
            'nombreCompleto' => 'required|string|max:255',
            'clienteFrecuente' => 'boolean',
            'telefono' => 'required|string|max:15|regex:/^[0-9]+$/', 
            'correo' => 'required|string|email|max:255|unique:clientes',
            'contrasenia' => 'required|string|min:8',
        ]);
    
        $clienteData = [
            'codigoCliente' => 0, 
            'nombreCompleto' => $validatedData['nombreCompleto'],
            'clienteFrecuente' => $req->has('clienteFrecuente') ? 1 : 0,
            'telefono' => $validatedData['telefono'],
            'correo' => $validatedData['correo'],
            'contrasenia' => $validatedData['contrasenia'],
        ];
    
        $client = new \GuzzleHttp\Client();
    
        try {
            Log::info('Datos enviados a la API:', $clienteData);
    
            $response = $client->post('http://localhost:8080/api/cliente/crear', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $clienteData,
            ]);
    
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
    
            Log::info('Respuesta de la API:', ['status' => $statusCode, 'body' => $body]);
    
            if ($statusCode == 200 || $statusCode == 201) {
                return redirect('/')->with('success', 'Cliente registrado exitosamente');
            } else {
                return redirect()->back()->withErrors(['api_error' => 'Error al registrar el cliente: ' . $body]);
            }
        } catch (\Exception $e) {
            Log::error('Error al conectar con la API externa: ' . $e->getMessage());
            return redirect()->back()->withErrors(['api_error' => 'Error al conectar con el servicio. Inténtalo nuevamente.']);
        }
    }
    
}

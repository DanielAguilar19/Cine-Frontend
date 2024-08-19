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
                // Realizar la solicitud GET a la API de Java para autenticar al usuario
                $response = $client->get('http://localhost:8080/api/cliente/obtenerPorCorreo', [
                    'query' => [
                        'correo' => $request->input('correo'), // Correo del usuario
                        'contrasenia' => $request->input('contrasenia'), // Contraseña del usuario
                    ],
                    'headers' => ['Accept' => 'application/json'],
                ]);
                // Decodificar la respuesta JSON
                $user = json_decode($response->getBody(), true);
                // Verificar si la respuesta contiene un código de cliente válido
                if (!empty($user) && isset($user['codigoCliente'])) {
                    // Guardar la información del usuario en la sesión de Laravel
                    Session::put('user', $user);
                    // Redirigir al usuario a la página de películas
                    return redirect()->route('peliculas');
                }
                // Si las credenciales no son correctas
                return back()->withErrors(['correo' => 'Correo o contraseña incorrecta']);
            } catch (\Exception $e) {
                // Registrar el error en los logs
                Log::error('Error al conectar con la API: ' . $e->getMessage());
                return back()->withErrors(['api_error' => 'Error al conectar con el servicio. Inténtalo nuevamente.']);
            }
        }
        // Redirigir a la página de inicio si no es una solicitud POST
        return redirect('/');
    }

    public function salvarCliente(Request $req) {
        $validatedData = $req->validate([
            'nombreCompleto' => 'required|string|max:255',
            'clienteFrecuente' => 'boolean',
            'fechaNacimiento' => 'required|date_format:Y-m-d',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|string|email|max:255|unique:clientes',
            'contrasenia' => 'required|string|min:8',
        ]);
    
        $clienteData = [
            'codigoCliente' => 0, // Puede ser omitido si la API lo maneja
            'nombreCompleto' => $validatedData['nombreCompleto'],
            'clienteFrecuente' => $req->has('clienteFrecuente') ? 1 : 0,
            'fechaNacimiento' => $validatedData['fechaNacimiento'],
            'telefono' => $validatedData['telefono'],
            'correo' => $validatedData['correo'],
            'contrasenia' => $validatedData['contrasenia'], // Enviar sin encriptar si la API se encarga de esto
        ];
    
        $client = new \GuzzleHttp\Client();
    
        try {
            // Loguea los datos que se enviarán
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
    
            // Loguea la respuesta de la API
            Log::info('Respuesta de la API:', ['status' => $statusCode, 'body' => $body]);
    
            if ($statusCode == 200 || $statusCode == 201) { // Verificar si es 201 Created
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

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    public function login(Request $request){
        if ($request->isMethod('post')) {
            $client = new Client();

            try {
                // Realizar la solicitud GET a la API usando Guzzle, pasando directamente los parámetros
                $response = $client->get('http://localhost:8080/api/cliente/obtenerPorCorreo', [
                    'query' => [
                        'correo' => $request->input('correo'), // Asegúrate de que el nombre del input sea "correo"
                        'contrasenia' => $request->input('contrasenia'), // Asegúrate de que el nombre del input sea "contrasenia"
                    ],
                    'headers' => ['Accept' => 'application/json'],
                ]);

                // Decodificar la respuesta JSON
                $user = json_decode($response->getBody(), true);

                // Verificar si la respuesta contiene un código de cliente válido
                if (!empty($user) && isset($user['codigoCliente'])) {
                    // Redirigir a la ruta de películas si la autenticación es exitosa
                    return redirect()->route('peliculas');
                }

                return back()->withErrors(['correo' => 'Correo o contraseña incorrecta']);
            } catch (\Exception $e) {
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
            'fechaNacimiento' => 'required|date',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|string|email|max:255|unique:clientes',
            'contrasenia' => 'required|string|min:8',
        ]);

        $clienteData = [
            'codigoCliente' => 0,
            'nombreCompleto' => $validatedData['nombreCompleto'],
            'clienteFrecuente' => $req->has('clienteFrecuente') ? 1 : 0,
            'fechaNacimiento' => $validatedData['fechaNacimiento'],
            'telefono' => $validatedData['telefono'],
            'correo' => $validatedData['correo'],
            'contrasenia' => $validatedData['contrasenia'],
        ];

        $client = new Client();

        try {
            $response = $client->post('http://localhost:8080/api/cliente/crear', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $clienteData,
            ]);

            if ($response->getStatusCode() == 200) {
                return redirect('/')->with('success', 'Cliente registrado exitosamente');
            } else {
                return redirect()->back()->withErrors(['api_error' => 'Error al registrar el cliente. Inténtalo nuevamente.']);
            }
        } catch (\Exception $e) {
            Log::error('Error al conectar con la API externa: ' . $e->getMessage());
            return redirect()->back()->withErrors(['api_error' => 'Error al conectar con el servicio. Inténtalo nuevamente.']);
        }
    }
}

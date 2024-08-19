<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request) {
        if ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return redirect()->intended('/');
            } else {
                return back()->withErrors([
                    'email' => 'Correo o contraseña incorrecta',
                ]);
            }
        }

        return view('login');
    }

    public function salvarCliente(Request $req){
        $validatedData = $req->validate([
            'nombreCompleto' => 'required|string|max:255',
            'clienteFrecuente' => 'boolean',
            'fechaNacimiento' => 'required|date',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|string|email|max:255|unique:clientes',
            'contrasenia' => 'required|string|min:8',
        ]);
    
        // Preparar los datos para enviar a la API externa
        $clienteData = [
            'codigoCliente' => 0,  // La API ignora este campo porque el ID es autogenerado
            'nombreCompleto' => $validatedData['nombreCompleto'],
            'clienteFrecuente' => $req->has('clienteFrecuente') ? 1 : 0,
            'fechaNacimiento' => $validatedData['fechaNacimiento'],
            'telefono' => $validatedData['telefono'],
            'correo' => $validatedData['correo'],
            'contrasenia' => $validatedData['contrasenia'],
        ];
        // Enviar los datos a la API externa
        try {
            $response = Http::post('http://localhost:8080/api/cliente/crear', $clienteData);
        
            if ($response->successful()) {
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
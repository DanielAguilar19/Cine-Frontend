<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula; 

class PeliculaController extends Controller
{
    public function index()
    {
        $peliculas = Pelicula::all(); 
        return view('peliculas', compact('peliculas')); 
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    protected $table = 'peliculas';
    protected $primaryKey = 'codigopelicula';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'duracion',
        'disponible',
        'descripcion',
        'imagen'
    ];
}

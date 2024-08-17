<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $table = 'administradores';
    protected $primaryKey = 'codigoadmin';
    public $timestamps = false;

    protected $fillable = [
        'nombrecompleto',
        'fechanacimiento',
        'telefono',
        'correo',
        'contrasenia'
    ];
}

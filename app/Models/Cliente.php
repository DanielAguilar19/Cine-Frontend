<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'codigocliente';
    public $timestamps = false;

    protected $fillable = [
        'nombrecompleto',
        'clientefrecuente',
        'fechanacimiento',
        'telefono',
        'correo',
        'contrasenia'
    ];

    public function factura()
    {
        return $this->hasMany(Factura::class, 'codigocliente', 'codigocliente');
    }
}

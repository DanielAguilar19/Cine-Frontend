<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $primaryKey = 'codigoevento';

    public $timestamps = false;

    protected $fillable = [
        'codigopelicula',
        'codigosala',
        'disponible',
        'horainicio',
        'fechaevento',
        'idioma',
        'formato'
    ];

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'codigopelicula', 'codigopelicula');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class, 'codigosala', 'codigosala');
    }

    public function boletos()
    {
        return $this->hasMany(Boleto::class, 'codigoevento', 'codigoevento');
    }
}

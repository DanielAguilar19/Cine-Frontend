<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsientoEvento extends Model
{
    protected $table = 'asientoevento';

    protected $primaryKey = 'codigoAsientoEvento';

    public $timestamps = false;

    protected $fillable = [
        'disponible',
        'codigoasiento',
        'codigoevento'
    ];

    public function asiento()
    {
        return $this->belongsTo(Asiento::class, 'codigoasiento', 'codigoasiento');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'codigoevento', 'codigoevento');
    }
}

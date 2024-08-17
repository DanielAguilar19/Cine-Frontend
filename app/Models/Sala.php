<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = 'salas';

    protected $primaryKey = 'codigosala';

    public $timestamps = false;

    protected $fillable = [
        'codigotiposala'
    ];

    public function tipoSala()
    {
        return $this->belongsTo(TipoSala::class, 'codigotiposala', 'codigotiposala');
    }

    public function asientos()
    {
        return $this->hasMany(Asiento::class, 'codigosala', 'codigosala');
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'codigosala', 'codigosala');
    }
}
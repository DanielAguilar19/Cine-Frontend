<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    protected $table = 'asientos';

    protected $primaryKey = 'codigoasiento';

    public $timestamps = false;

    protected $fillable = [
        'codigosala', 
        'disponible', 
        'numeroasiento'
    ];

    public function sala()
    {
        return $this->belongsTo(Sala::class, 'codigosala', 'codigosala');
    }

    public function boletos()
    {
        return $this->hasMany(Boleto::class, 'codigoasiento', 'codigoasiento');
    }
}
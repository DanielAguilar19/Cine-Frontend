<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
    protected $table = 'boletos';

    protected $primaryKey = 'codigoboleto';

    public $timestamps = false;

    protected $fillable = [
        'codigoevento',
        'codigoasiento',
        'codigodetallefactura'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'codigoevento', 'codigoevento');
    }

    public function asiento()
    {
        return $this->belongsTo(Asiento::class, 'codigoasiento', 'codigoasiento');
    }

    public function detalleFactura()
    {
        return $this->belongsTo(DetalleFactura::class, 'codigodetallefactura', 'codigodetallefactura');
    }
}

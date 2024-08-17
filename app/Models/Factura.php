<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'codigofactura';
    public $timestamps = false;

    protected $fillable = [
        'codigocliente',
        'numerotarjeta',
        'fechacompra',
        'descuento',
        'totalcompra'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'codigocliente', 'codigocliente');
    }

    public function detallefactura()
    {
        return $this->hasMany(DetalleFactura::class, 'codigofactura', 'codigofactura');
    }
}

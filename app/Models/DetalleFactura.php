<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $table = 'detallefactura';

    protected $primaryKey = 'codigodetallefactura';

    public $timestamps = false;

    protected $fillable = [
        'cantidadboletos',
        'codigofactura',
        'subtotal'
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'codigofactura', 'codigofactura');
    }

    public function boletos()
    {
        return $this->hasMany(Boleto::class, 'codigodetallefactura', 'codigodetallefactura');
    }
}

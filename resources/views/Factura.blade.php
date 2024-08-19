<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetalleFactura;

class FacturaController extends Controller
{
    public function store(Request $request){
        // Validar datos
        $request->validate([
            'nombreCliente' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'nombrePelicula' => 'required|string|max:255',
            'numeroBoletos' => 'required|integer|min:1',
            'asientos' => 'required|array',
            'asientos.*' => 'required|string|max:10',
            'itemsFactura' => 'required|array',
            'itemsFactura.*.descripcion' => 'required|string|max:255',
            'itemsFactura.*.cantidad' => 'required|integer|min:1',
            'itemsFactura.*.precioUnitario' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'impuesto' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'codigoAsientos' => 'required|string', // nueva validación
            'codigoEvento' => 'required|integer',
        ]);
        
        // Guardar la factura
        $factura = new Factura();
        $factura->numero_factura = $this->generateFacturaNumber(); // Generar número de factura
        $factura->nombre_cliente = $request->nombreCliente;
        $factura->fecha = $request->fecha;
        $factura->hora = $request->hora;
        $factura->nombre_pelicula = $request->nombrePelicula;
        $factura->numero_boletos = $request->numeroBoletos;
        $factura->subtotal = $request->subtotal;
        $factura->impuesto = $request->impuesto;
        $factura->total = $request->total;
        $factura->save();
        
        // Guardar los detalles de la factura
        foreach ($request->itemsFactura as $item) {
            $detalle = new DetalleFactura();
            $detalle->factura_id = $factura->id;
            $detalle->descripcion = $item['descripcion'];
            $detalle->cantidad = $item['cantidad'];
            $detalle->precio_unitario = $item['precioUnitario'];
            $detalle->total = $item['cantidad'] * $item['precioUnitario'];
            $detalle->save();
        }
    
        // Guardar los asientos y crear boletos
        $codigoAsientos = explode(',', $request->codigoAsientos);
        foreach ($codigoAsientos as $codigoAsiento) {
            $boleto = new Boleto();
            $boleto->codigoEvento = $request->codigoEvento;
            $boleto->codigoAsiento = $codigoAsiento;
            $boleto->codigoDetalleFactura = $detalle->id;
            $boleto->save();
        }
    
        return redirect()->back()->with('success', 'Factura creada exitosamente');
    }
}

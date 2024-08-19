<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetalleFactura;

class FacturaController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
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
        ]);

        try {
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

            // Guardar los asientos
            foreach ($request->asientos as $asiento) {
                $detalle = new DetalleFactura();
                $detalle->factura_id = $factura->id;
                $detalle->descripcion = "Asiento " . $asiento;
                $detalle->cantidad = 1;
                $detalle->precio_unitario = 0; // Asume que el precio ya está incluido en el boleto
                $detalle->total = 0;
                $detalle->save();
            }

            return redirect()->back()->with('success', 'Factura creada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al crear la factura');
        }
    }

    private function generateFacturaNumber()
    {
        $lastFactura = Factura::orderBy('id', 'desc')->first();
        $lastNumber = $lastFactura ? $lastFactura->numero_factura : 0;
        return $lastNumber + 1;
    }
}

<?php

namespace App\Http\Controllers;



use App\Models\Alquiler;


class PagoController extends Controller{

    public function detalles($id){
        try {
            // Busca la transacción en la base de datos
            $pago = Alquiler::where('transaction_id', $id)->firstOrFail();

            // Redondea los valores a 2 decimales
            $precioTotal = $pago->precio_total;
            $comisiones = $precioTotal * 0.05;
            $recibir = $precioTotal * 0.95;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'transaction_id' => $pago->transaction_id,
                    'Total' => round($precioTotal, 2), // Redondeado a 2 decimales
                    'Recibir' => round($recibir, 2), // Redondeado a 2 decimales
                    'Comisiones' => round($comisiones, 2), // Redondeado a 2 decimales
                    'fecha_inicio' => \Carbon\Carbon::parse($pago->fecha_inicio)->format('d-m-Y'),
                    'fecha_fin' => \Carbon\Carbon::parse($pago->fecha_fin)->format('d-m-Y'),
                ],
            ]);
        } catch (\Exception $e) {
            // Log del error
            \Log::error("Error obteniendo detalles del pago: " . $e->getMessage());

            // Retorna un error en formato JSON
            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo obtener los detalles del pago.',
            ], 500);
        }
    }
}

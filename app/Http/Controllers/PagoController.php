<?php

namespace App\Http\Controllers;



use App\Models\Alquiler;


class PagoController extends Controller{
    
    public function detalles($id){
        try {
            // Busca la transacción en la base de datos
            $pago = Alquiler::where('transaction_id', $id)->firstOrFail();

            // Retorna los detalles del pago
            return response()->json([
                'status' => 'success',
                'data' => [
                    'transaction_id' => $pago->transaction_id,
                    'Total' => $pago->precio_total,
                    'Recibir' => $pago->precio_total * 0.95,
                    'Comisiones' => $pago->precio_total * 0.05,
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

<?php 

namespace App\Http\Controllers;

use App\Models\EntregaRecogida;
use App\Models\Alquiler;
use Illuminate\Http\Request;

class EntregaRecogidaController extends Controller
{
    // Registrar un nuevo evento
    public function registrarEvento(Request $request)
    {
        $request->validate([
            'alquiler_id' => 'required|exists:alquilers,id',
            'estado' => 'required|in:home,entregado,en alquiler,devuelto',
            'notas' => 'nullable|string',
            'fotos' => 'nullable|array', // Recibe un array de URLs
        ]);

        $entregaRecogida = EntregaRecogida::create([
            'alquiler_id' => $request->alquiler_id,
            'estado' => $request->estado,
            'fecha_evento' => now(),
            'notas' => $request->notas,
            'fotos' => $request->fotos,
        ]);

        return response()->json([
            'message' => 'Evento registrado exitosamente.',
            'entrega_recogida' => $entregaRecogida,
        ]);
    }

    // Obtener todos los eventos de un alquiler
    public function obtenerEventos($alquiler_id)
    {
        $entregasRecogidas = EntregaRecogida::where('alquiler_id', $alquiler_id)->orderBy('fecha_evento', 'asc')->get();

        return response()->json($entregasRecogidas);
    }
}

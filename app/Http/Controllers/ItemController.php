<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    // Mostrar la vista con el listado y el formulario
    public function index()
    {
        // Obtenemos los items que no se muestran en la aplicación
        $items = Item::where('visible', true)->get(); // Ajusta según tu lógica
        return view('ofertas.index', compact('items'));
    }

    // Guardar un nuevo item
    public function store(Request $request)
    {
        $request->merge([
            'nombre' => strip_tags($request->input('nombre')), 
            'descripcion' => strip_tags($request->input('descripcion')), 
        ]);
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        // Crear el nuevo item asociado al usuario autenticado
        Item::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'user_id' => auth()->id(), // Asocia el ID del usuario autenticado
            'visible' => true, // Por defecto no será visible
        ]);

        return redirect()->route('ofertas.index')->with('success', '¡Oferta publicada con éxito!');
    }

    public function destroy($id){
        // Buscar el item por su ID
        $item = Item::findOrFail($id);
    
        // Verificar si el usuario es el autor del item o si la publicación tiene más de un mes
        if (auth()->user()->id !== $item->user_id && $item->created_at->gte(now()->subMonth())) {
            abort(403, 'No tienes permiso para eliminar este item.');
        }
    
        // Si el item tiene más de un mes de antigüedad, solo lo hacemos no visible
        if ($item->updated_at->lt(now()->subMonth())) {
            $item->update(['visible' => false]);
            return back()->with('success', 'Item deshabilitado correctamente.');  // Cambiar el mensaje
        }
    
        // Si no, eliminamos el item
        $item->delete();
        return back()->with('success', 'Item eliminado correctamente.');
    }
}    

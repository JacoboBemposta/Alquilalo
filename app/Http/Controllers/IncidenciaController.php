<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Alquiler;
use Illuminate\Http\Request;

class IncidenciaController extends Controller{

    public function store(Request $request)
    {
        // Depurar los datos del request
        //dd($request->all()); 
        
        // Validar los datos
        $request->validate([
            'alquiler_id' => 'required|exists:alquilers,id',
            'descripcion' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // Añadido 'webp' a los tipos permitidos
        ]);


            $request->merge([
                'descripcion' => strip_tags($request->input('descripcion')),
            ]);
    

    
        // Procesar la imagen si se sube
        if ($request->hasFile('foto')) {
            // Obtener el ID del alquiler
            $alquilerId = $request->alquiler_id;
        
            // Crear una carpeta con el ID del alquiler dentro de 'incidencias_fotos'
            $fotoPath = $request->file('foto')->store("incidencias_fotos/{$alquilerId}", 'public');
        } else {
            $fotoPath = null;
        }
        
    
        // Crear la incidencia
        $incidencia = Incidencia::create([
            'alquiler_id' => $request->alquiler_id,
            'descripcion' => $request->descripcion,
            'ruta_imagen' => $fotoPath,  // Guardar la ruta de la imagen
            'resuelta' => false,  // Estado inicial
        ]);
    
        return redirect()->back()->with('success', 'Incidencia abierta correctamente.');
    }
    
    
    public function mostrarAlquiler($id)
    {
        // Obtener el alquiler por su ID
        $alquiler = Alquiler::findOrFail($id);
        
        // Obtener la incidencia relacionada con el alquiler
        $incidencia = Incidencia::where('alquiler_id', $alquiler->id)->first(); // Recupera la incidencia si existe
        
        // Pasar los datos a la vista
        return view('nombre_de_la_vista', compact('alquiler', 'incidencia'));
    }
    
    public function aprobar($id){
        // Buscar la incidencia por su ID
        $incidencia = Incidencia::findOrFail($id);
    
        // Actualizar el estado de 'aprobado'
        $incidencia->aprobado = true;
        $incidencia->save();
    
        // Redirigir con mensaje de éxito
        return redirect()->route('incidencias.index')->with('success', 'Incidencia resuelta positivamente.');
    }
    
    public function rechazar($id){
        // Buscar la incidencia por su ID
        $incidencia = Incidencia::findOrFail($id);
    
        // Actualizar el estado de 'aprobado' a false
        $incidencia->aprobado = true;
        $incidencia->save();
    
        // Redirigir con mensaje de éxito
        return redirect()->route('incidencias.index')->with('success', 'Incidencia rechazada.');
    }
    
}

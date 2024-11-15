<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Valoracion $valoracion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Valoracion $valoracion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Valoracion $valoracion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Valoracion $valoracion)
    {
        //
    }

    public function guardar(Request $request)
    {
        $request->merge([
            'id_producto' => strip_tags($request->input('id_producto')), 
            'puntuacion' => strip_tags($request->input('puntuacion')), 
            'descripcion' => strip_tags($request->input('descripcion')), 
            'ruta_imagen' => strip_tags($request->input('ruta_imagen')), 
        ]);
        // Validar los datos de entrada
        $request->validate([
            'id_producto' => 'required|exists:productos,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'descripcion' => 'required|string|max:255',
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // La imagen es opcional, máximo 2MB
        ]);
    
        // Crear una nueva instancia de Valoracion
        $valoracion = new Valoracion();
        $valoracion->id_producto = $request->id_producto;
        $valoracion->id_usuario = Auth::id(); // Asignar el usuario autenticado
        $valoracion->puntuacion = $request->puntuacion;
        $valoracion->descripcion = $request->descripcion;
    
        // Si se ha subido una imagen, guardarla en una carpeta específica para el producto
        if ($request->hasFile('ruta_imagen')) {
            // Generar la ruta específica para el producto
            $rutaDirectorio = 'valoraciones/' . $request->id_producto;
    
            // Obtener el nombre original de la imagen
            $nombreImagen = $request->file('ruta_imagen')->getClientOriginalName();
    
            // Guardar la imagen en la ruta especificada con su nombre original
            $path = $request->file('ruta_imagen')->storeAs($rutaDirectorio, $nombreImagen, 'public');
            
            // Asignar la ruta de la imagen en la base de datos
            $valoracion->ruta_imagen = $path;
        }
    
        // Guardar la valoración en la base de datos
        $valoracion->save();
    
        // Redirigir al usuario de vuelta a la página del producto con un mensaje de éxito
        return redirect()->route('productos.verproducto', $request->id_producto)
                         ->with('success', '¡Valoración enviada exitosamente!');
    }

    
}

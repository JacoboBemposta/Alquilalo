<?php

namespace App\Http\Controllers;

use App\Models\ImagenProducto;
use App\Http\Requests\StoreImagenProductoRequest;
use App\Http\Requests\UpdateImagenProductoRequest;
use App\Models\Producto;

class ImagenProductoController extends Controller
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
    public function store(StoreImagenProductoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
    $producto = Producto::with('imagenes')->findOrFail($id);
    return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImagenProducto $imagenProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImagenProductoRequest $request, ImagenProducto $imagenProducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImagenProducto $imagenProducto)
    {
        //
    }
}

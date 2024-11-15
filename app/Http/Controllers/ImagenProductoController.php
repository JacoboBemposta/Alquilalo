<?php

namespace App\Http\Controllers;

use App\Models\ImagenProducto;
use App\Http\Requests\StoreImagenProductoRequest;
use App\Http\Requests\UpdateImagenProductoRequest;
use App\Models\Producto;

class ImagenProductoController extends Controller{

    /**
     * Display the specified resource.
     */
    public function show($id){
        $producto = Producto::with('imagenes')->findOrFail($id);
        return view('productos.show', compact('producto'));
        }    

    public function index(){
        //
    }

    public function create(){
        //
    }


    public function store(StoreImagenProductoRequest $request){
        //
    }


    public function edit(ImagenProducto $imagenProducto){
        //
    }

    public function update(UpdateImagenProductoRequest $request, ImagenProducto $imagenProducto){
        //
    }


    public function destroy(ImagenProducto $imagenProducto){
        //
    }
}

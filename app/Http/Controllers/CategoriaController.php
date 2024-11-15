<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Subcategoria;

class CategoriaController extends Controller{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $categorias = Categoria::with('subcategorias')->get();

        return view('categorias.index', compact('categorias'));
    }

    
    public function getSubcategorias($categoria_id){
        try {
            $subcategorias = Subcategoria::where('id_categoria', $categoria_id)->get();
            return response()->json($subcategorias);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create(){
        //
    }


    public function store(StoreCategoriaRequest $request){
        //
    }


    public function show(Categoria $categoria){
        //
    }


    public function edit(Categoria $categoria){
        //
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria){
        //
    }


    public function destroy(Categoria $categoria){
        //
    }

}

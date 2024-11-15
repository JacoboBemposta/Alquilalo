<?php

namespace App\Http\Controllers;

use App\Models\Subcategoria;
use App\Http\Requests\StoreSubcategoriaRequest;
use App\Http\Requests\UpdateSubcategoriaRequest;


class SubcategoriaController extends Controller{

    public function show($id){
        $subcategoria = Subcategoria::findOrFail($id);
        return view('subcategoria.show', compact('subcategoria'));
    }    
    /**
     * Display a listing of the resource.
     */
    public function index($id){
        $subcategoria = Subcategoria::findOrFail($id);
        $productos = $subcategoria->productos()->paginate(10); // Ajusta la paginación según tus necesidades
    
        // Verificar si la solicitud es AJAX
        if (request()->ajax()) {
            $view = view('productos.data', compact('productos'))->render(); // Cambia a tu vista parcial
            return response()->json([
                'html' => $view,
                'next_page' => $productos->hasMorePages(), // `hasMorePages` verifica si hay más productos
            ]);
        }
    
        // Si no es AJAX, cargar la vista completa
        return view('subcategorias.index', compact('subcategoria', 'productos'));
    }
    
    

    public function create(){
        //
    }


    public function store(StoreSubcategoriaRequest $request){
        //
    }


    public function edit(Subcategoria $subcategoria){
        //
    }


    public function update(UpdateSubcategoriaRequest $request, Subcategoria $subcategoria){
        //
    }


    public function destroy(Subcategoria $subcategoria){
        //
    }


}

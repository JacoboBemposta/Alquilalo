<?php

namespace App\Http\Controllers;

use App\Models\Subcategoria;
use App\Http\Requests\StoreSubcategoriaRequest;
use App\Http\Requests\UpdateSubcategoriaRequest;

class SubcategoriaController extends Controller
{

    public function show($id)
    {
        $subcategoria = Subcategoria::findOrFail($id);
        return view('subcategoria.show', compact('subcategoria'));
    }    
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $subcategoria = Subcategoria::findOrFail($id);
        $productos = $subcategoria->productos()->paginate(10);  // Ajusta a la relación correcta

        return view('subcategorias.index', compact('subcategoria', 'productos'));
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
    public function store(StoreSubcategoriaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategoria $subcategoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubcategoriaRequest $request, Subcategoria $subcategoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategoria $subcategoria)
    {
        //
    }


}

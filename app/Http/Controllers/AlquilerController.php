<?php

namespace App\Http\Controllers;

use App\Models\Alquiler;
use App\Http\Requests\StoreAlquilerRequest;
use App\Http\Requests\UpdateAlquilerRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlquilerController extends Controller
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
        $request->validate([
            'id_producto' => 'required|integer|exists:productos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'precio_total' => 'required|numeric',
        ]);

        // Obtener el producto y su arrendador
        $producto = Producto::findOrFail($request->id_producto);
        $arrendador_id = $producto->id_usuario; // Suponiendo que el campo 'id_usuario' en la tabla productos es el arrendador

        // Obtener el usuario autenticado como arrendatario
        $arrendatario_id = Auth::id();

        // Crear el alquiler
        $alquiler = Alquiler::create([
            'id_producto' => $producto->id,
            'id_arrendador' => $arrendador_id,
            'id_arrendatario' => $arrendatario_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'precio_total' => $request->precio_total,
        ]);

        return response()->json($alquiler, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Alquiler $alquiler)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alquiler $alquiler)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlquilerRequest $request, Alquiler $alquiler)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alquiler $alquiler)
    {
        //
    }
}

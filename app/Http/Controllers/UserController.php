<?php

namespace App\Http\Controllers;

use App\Models\caracteristica;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\ImagenProducto;
use App\Models\Alquiler;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;


class UserController extends Controller
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
    public function show()
    {
        // Obtener el usuario por su id
        $usuario = User::findOrFail(Auth::user()->id);
    
        // Obtener los alquileres como arrendatario
        $alquileresComoArrendatario = $usuario->alquileresComoArrendatario()->with('producto')->get();
    
        // Obtener los alquileres como arrendador
        $alquileresComoArrendador = $usuario->alquileresComoArrendador()->with('producto')->get();
    

    
        return view('usuarios.perfil', compact(
            'usuario', 
            'alquileresComoArrendatario', 
            'alquileresComoArrendador', 
            'alquileresComoArrendatario', 
            'alquileresComoArrendador'
        ));
    }
    
    
    
    public function alquileres()
    {
        $user = Auth::user();
    
        // Obtener todos los alquileres realizados por el usuario logueado
        $alquileres = $user->alquilers()->with('producto')->get();
    
        // Calcular el acumulado de cada producto alquilado por el usuario
        $acumuladoProductos = $alquileres->groupBy('producto_id')->map(function ($alquileresProducto) {
            return [
                'producto' => $alquileresProducto->first()->producto, // Obtener el producto
                'cantidad_total' => $alquileresProducto->count(), // Cantidad de veces alquilado
                'total_acumulado' => $alquileresProducto->sum('precio') // Suma de precios
            ];
        });
    
        return view('perfil', [
            'user' => $user,
            'alquileres' => $alquileres,
            'acumuladoProductos' => $acumuladoProductos,
        ]);
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
    public function update(UpdateValoracionRequest $request, Valoracion $valoracion)
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
}

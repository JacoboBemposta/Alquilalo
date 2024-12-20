<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Carbon\Carbon;


class UserController extends Controller{


    public function show() {
        $usuario = User::findOrFail(Auth::user()->id);
    
        $alquileresComoArrendatario = $usuario->alquileresComoArrendatario()
            ->with(['producto', 'incidencia'])
            ->get();
    
        $alquileresComoArrendador = $usuario->alquileresComoArrendador()
            ->with(['producto', 'incidencia'])
            ->get();
    
        // Depuración: verifica los datos
   
    
        return view('usuarios.perfil', compact(
            'usuario',
            'alquileresComoArrendatario',
            'alquileresComoArrendador'
        ));
    }
    
    
    
    
    
    public function alquileres(){
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

    public function edit(Valoracion $valoracion){
        //
    }


    public function update(UpdateValoracionRequest $request, Valoracion $valoracion){
        //
    }


    public function destroy(Valoracion $valoracion){
        //
    }

    public function index(){
        //
    }

   
    public function create(){
        //
    }

 
    public function store(Request $request){
        //
    }

}

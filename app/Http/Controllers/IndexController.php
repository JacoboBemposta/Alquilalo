<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(){
    // Obtener productos ordenados por fecha
    $productosPorFecha = Producto::orderBy('created_at', 'desc')->get();

    // Obtener productos ordenados por descuento (de mayor a menor)
    $productosPorDescuento = Producto::whereHas('caracteristicas', function($query) {
            $query->where('descuento', '>', 0); // Filtrar solo productos con descuento
        })
        ->with(['caracteristicas' => function($query) {
            $query->orderByDesc('descuento'); // Ordenar características por descuento descendente
        }])
        ->get()
        ->sortByDesc(function($producto) {
            return $producto->caracteristicas->first()->descuento;
        });

    return view('index', compact('productosPorFecha', 'productosPorDescuento'));
    }
}

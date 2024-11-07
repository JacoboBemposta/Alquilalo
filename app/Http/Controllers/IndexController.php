<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class IndexController extends Controller{
    public function __invoke(){

            // Obtener productos ordenados por fecha
    $productosPorFecha = Producto::orderBy('created_at', 'desc')->get();

    // Obtener productos ordenados por descuento (de mayor a menor)
    $productosPorDescuento = Producto::whereHas('caracteristicas', function($query) {
        $query->where('descuento', '>', 0);
    })
    ->with('caracteristicas')
    ->get()
    ->sortByDesc(function($producto) {
        return $producto->caracteristicas ? $producto->caracteristicas->descuento : 0;
    });
    $productosOrdenados = $productosPorDescuento->sortByDesc(function($producto) {
        return $producto->caracteristicas ? $producto->caracteristicas->descuento : 0;
    });
    
    // Si quieres que el resultado sea una colección y no se altere el original
    $productosPorDescuento = $productosOrdenados->values();

    $productosPorValoracion = Producto::orderByDesc('valoracion_media')->get();
    
    return view('index', compact('productosPorFecha', 'productosPorDescuento','productosPorValoracion'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Alquiler;
use Illuminate\Http\Request;

class AdminController extends Controller{


    public function index()
    {
        $alquileres = Alquiler::with(['producto', 'arrendatario', 'entregasRecogidas' => function ($query) {
            $query->latest()->limit(1); // Solo carga el registro más reciente
        }])->get();
    
        return view('admin.alquileres.index', compact('alquileres'));
    }
    

    public function detallesAlquiler($id) {
        // Encuentra el alquiler
        $alquiler = Alquiler::findOrFail($id);
    
        // Obtiene el último estado de entregas_recogidas
        $ultimoRegistro = $alquiler->entregasRecogidas()->latest()->first();
    
        // Asigna 'home' como estado predeterminado si no hay registros
        $estado = $ultimoRegistro ? $ultimoRegistro->estado : 'home';
    
        // Pasar alquiler y estado a la vista
        return view('admin.gestionar_alquiler', compact('alquiler', 'estado'));
    }
    
    
}

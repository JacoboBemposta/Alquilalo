<?php

namespace App\Http\Controllers;

use App\Models\Alquiler;
use App\Models\Producto;
use App\Models\EntregaRecogida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AlquilerController extends Controller
{
    public function mostrarFormularioReserva(Producto $producto){
        // Obtener todas las reservas futuras del producto
        $reservas = Alquiler::where('id_producto', $producto->id)
            ->where('fecha_inicio', '>=', now())  // Solo reservas futuras
            ->get();
    
        // Formatear las fechas reservadas
        $fechas_reservadas = $reservas->map(function ($reserva) {
            return Carbon::parse($reserva->fecha_inicio)->format('d-m-Y'); // Solo la fecha de inicio
        });
    
        // Pasar las fechas reservadas al frontend
        return view('productos.reservar', [
            'producto' => $producto,
            'fechas_reservadas' => $fechas_reservadas
        ]);
    }

    public function store(Request $request){
        
        $request->merge([
            'id_producto' => strip_tags($request->input('id_producto')), 
            'fecha_inicio'=> strip_tags($request->input('fecha_inicio')), 
            'fecha_fin'=> strip_tags($request->input('fecha_fin')), 
            'precio_total'=> strip_tags($request->input('precio_total')),
        ]);
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

        $producto->acumulado += $request->precio_total;

        $producto->save();
        return response()->json($alquiler, 201);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $id_producto)
    {
        $alquiler = Alquiler::findOrFail($id);
        $producto = Producto::findOrFail($id_producto);
    
        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }
    
        // Obtener todas las reservas del producto, excluyendo el alquiler que estamos editando
        $reservas = Alquiler::where('id_producto', $producto->id)
                            ->where('id', '!=', $id) // Excluimos el alquiler que estamos editando
                            ->get();
    
        // Array para almacenar todas las fechas reservadas
        $fechas_reservadas = [];
    
        foreach ($reservas as $reserva) {
            // Asegurarse de que fecha_inicio y fecha_fin son instancias de Carbon
            $fecha_inicio = Carbon::parse($reserva->fecha_inicio)->format('Y-m-d');
            $fecha_fin = Carbon::parse($reserva->fecha_fin)->format('Y-m-d');
    
            // Si la reserva tiene un rango de fechas (fecha_inicio y fecha_fin)
            $fecha_actual = Carbon::parse($fecha_inicio);
    
            // Iterar desde la fecha de inicio hasta la fecha de fin
            while ($fecha_actual <= Carbon::parse($fecha_fin)) {
                // Agregar cada fecha al array de fechas reservadas
                $fechas_reservadas[] = $fecha_actual->format('Y-m-d');
                $fecha_actual->addDay();  // Incrementar un día
            }
        }
    
        // Pasar a la vista los datos necesarios
        return view('alquileres.edit', compact('alquiler', 'producto', 'fechas_reservadas'));
    }
    

    public function cancelar($id)
    {
        $alquiler = Alquiler::findOrFail($id);
    
        // Verificar si el usuario actual es el arrendador o arrendatario
        if (Auth::user()->id == $alquiler->arrendador->id || Auth::user()->id == $alquiler->arrendatario->id) {
            $alquiler->delete();
            return redirect()->route('perfil')->with('success', 'Alquiler eliminado correctamente.');
        }
    
        return redirect()->route('perfil')->with('error', 'No tienes permiso para eliminar este alquiler.');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'fecha_inicio' => strip_tags($request->input('fecha_inicio')), 
            'fecha_fin'=> strip_tags($request->input('fecha_fin')), 
            'precio_total'=> strip_tags($request->input('precio_total')), 
        ]); 
        // Validación de los datos
        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'precio_total' => 'required|numeric|min:1',
        ]);
    
        $alquiler = Alquiler::findOrFail($id);
        
        // Verificación de si el alquiler ya ha comenzado (fecha de inicio ya pasada)
        if (\Carbon\Carbon::parse($alquiler->fecha_inicio)->isPast()) {
            return redirect()->route('alquileres.index')->with('error', 'No puedes editar un alquiler que ya ha comenzado.');
        }
    
        // Actualización de los datos
        $alquiler->fecha_inicio = $request->input('fecha_inicio');
        $alquiler->fecha_fin = $request->input('fecha_fin');
        $alquiler->precio_total = $request->input('precio_total');
        $alquiler->save();
    
        return redirect()->route('perfil')->with('success', 'Alquiler actualizado correctamente');
    }
    

    public function cancelarAlquiler(Alquiler $alquiler)
    {
        DB::beginTransaction();
        try {
            // Lógica de eliminación y actualización del acumulado
            $producto = $alquiler->producto;
            $producto->acumulado -= $alquiler->precio_total;
            $producto->save();
            $alquiler->delete();
    
            // Commit de la transacción
            DB::commit();
            
            return redirect()->route('perfil')->with('success', 'Alquiler eliminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hubo un error al eliminar el alquiler');
        }
    }

    public function show(Alquiler $alquiler){
        //
    }    

    public function index(){
        //
    }

    public function create(){
        //
    }

    public function gestionarAlquileres(){
        // Solo permitir acceso si el usuario es administrador
        if (auth()->user()->email !== 'admin@gmail.com') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    
        // Obtener todos los alquileres con relaciones de productos y usuarios
        $alquileres = Alquiler::with(['producto', 'arrendatario', 'arrendador'])->get();
    
        return view('admin.gestionar_alquileres', compact('alquileres'));
    }


    public function cambiarEstado(Request $request, $id)
    {
        // Encuentra el alquiler por su ID
        $alquiler = Alquiler::findOrFail($id);
    
        // Obtén el último registro de entregas_recogidas
        $ultimoEstado = $alquiler->entregasRecogidas()->latest()->first();
    
        // Si no existe, asignamos un estado por defecto
        if (!$ultimoEstado) {
            $ultimoEstado = new EntregaRecogida();
            $ultimoEstado->alquiler_id = $alquiler->id;
            $ultimoEstado->estado =  $request->input('estado'); // Estado inicial si no hay registros previos
            $ultimoEstado->fecha_evento = now();
            $ultimoEstado->save();
        }
    
        // Crea un nuevo registro de entrega_recogida con el estado seleccionado
        $entregaRecogida = new EntregaRecogida();
        $entregaRecogida->alquiler_id = $alquiler->id;  // Relación con el alquiler
        $entregaRecogida->estado = $request->input('estado');  // Estado elegido por el usuario
        $entregaRecogida->fecha_evento = now();  // Fecha y hora actual
        $entregaRecogida->save();  // Guardamos el nuevo registro
    
        // Redirige con un mensaje de éxito
        return redirect()->route('admin.alquileres', ['id' => $id])->with('success', 'Estado actualizado correctamente.');
    }
    
    
}

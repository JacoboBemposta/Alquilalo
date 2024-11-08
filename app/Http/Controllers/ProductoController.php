<?php

namespace App\Http\Controllers;

use App\Models\caracteristica;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\ImagenProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Alquiler;
use Carbon\Carbon;

class ProductoController extends Controller{

    /**
     * Devuelve la vista de productos ordenados
     * por novedades y por descuentos
     */
public function index(){

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
    
    return view('productos.index', compact('productosPorFecha', 'productosPorDescuento','productosPorValoracion'));
}

    /**
     * Devuelve la vista del formulario para dar de alta un producto.
     */
    public function create(){
        $categorias = Categoria::with('subcategorias')->get();
        $user_id = Auth::id();
        return view('productos.crear',compact('categorias','user_id'));
    }

    /**
     * Almacenar productos en la bdd.
     */
    public function store(Request $request){        
        // Crear el producto
        $producto = Producto::create($request->only('id_categoria','id_subcategoria','id_usuario','nombre','descripcion','precio_dia','precio_semana','precio_mes','disponible'));
        // Manejar las imágenes
        Caracteristica::create([
            'id_producto' => $producto->id,
            'novedad' => 1,
            'descuento' =>$request->descuento,
            'descripcion' =>$request->descripcionlarga,
        ]);
       if ($request->hasFile('imagenes')) {
        foreach ($request->file('imagenes') as $imagen) {
            // Obtener la extensión de la imagen
            $extension = $imagen->getClientOriginalExtension();
            
            // Generar un nombre único para la imagen
            $nombreImagen = $imagen->getClientOriginalName();

            // Almacenar la imagen en la carpeta correspondiente
            $ruta = $imagen->storeAs('productos/' . $producto->id, $nombreImagen, 'public');
            
            // Crear el registro de la imagen en la base de datos
            ImagenProducto::create([
                'ruta_imagen' => $ruta,
                'nombre' => $nombreImagen,
                'id_producto' => $producto->id
            ]);
            }
        }
    $user_id = Auth::id();
    // Obtener todos los productos del usuario logeado
    $productosDelUsuario = Producto::where('id_usuario', $user_id)->get();

    return view('productos.usuario',compact('productosDelUsuario'));
    }

    public function misproductos(Producto $producto){
    
        $user_id = Auth::id();
        // Obtener todos los productos del usuario logeado
     $productosDelUsuario = Producto::where('id_usuario', $user_id)->get();

        return view('productos.usuario',compact('productosDelUsuario'));
    }
    public function actualizar(Producto $producto) {
        // Obtener todas las categorías con sus subcategorías
        $categorias = Categoria::with('subcategorias')->get();
        
        // Obtener la categoría del producto actual
        $categoriaActual = $producto->categoria; // Suponiendo que tienes una relación definida en el modelo Producto
        
        // Obtener las subcategorías de la categoría actual
        $subcategorias = $categoriaActual ? $categoriaActual->subcategorias : collect(); // Evita errores si no hay categoría asignada
    
        return view('productos.actualizar', compact('producto', 'categorias', 'subcategorias'));
    }


    public function show(Producto $producto)
    {
        //
    }

        /**
     * Actualizar datos de un producto
     */
    public function edit(Request $request) {
        $producto = Producto::find($request->id_producto);
        $producto->id_categoria = $request->id_categoria;
        $producto->id_subcategoria = $request->id_subcategoria;
        $producto->descripcion = $request->descripcion;
        $producto->precio_dia = $request->precio_dia;
        $producto->precio_semana = $request->precio_semana;
        $producto->precio_mes = $request->precio_mes;
        $producto->save();
 
        if ($producto->caracteristicas) {
            $producto->caracteristicas->descuento = $request->descuento;
            $producto->caracteristicas->descripcion = $request->descripcionlarga;
            $producto->caracteristicas->save();
        }
    
        // Verificar si hay imágenes nuevas en la solicitud
        if ($request->hasFile('imagenes')) {
            // Eliminar las imágenes previas solo si se suben nuevas imágenes
            $imagenesPrevias = ImagenProducto::where('id_producto', $producto->id)->get();
            foreach ($imagenesPrevias as $imagenPrevia) {
                Storage::disk('public')->delete($imagenPrevia->ruta_imagen);
                $imagenPrevia->delete();
            }
    
            foreach ($request->file('imagenes') as $imagen) {
                // Obtener la extensión de la imagen
                $extension = $imagen->getClientOriginalExtension();
    
                // Generar un nombre único para la imagen
                $nombreImagen = $imagen->getClientOriginalName();
    
                // Almacenar la imagen en la carpeta correspondiente
                $ruta = $imagen->storeAs('productos/' . $producto->id, $nombreImagen, 'public');
    
                // Crear el registro de la imagen en la base de datos
                ImagenProducto::create([
                    'ruta_imagen' => $ruta,
                    'nombre' => $nombreImagen,
                    'id_producto' => $producto->id
                ]);
            }
        }
    
        $user_id = Auth::id();
        // Obtener todos los productos del usuario logeado
        $productosDelUsuario = Producto::where('id_usuario', $user_id)->get();
    
        return view('productos.usuario', compact('productosDelUsuario'));
    }
    


    public function update(Request $request, Producto $producto)
    {
        //
    }
    /**
     * Ver un registro
     */
    public function verproducto(Producto $producto)
    {
        // Obtener todas las reservas del producto
        $reservas = Alquiler::where('id_producto', $producto->id)->get();
    
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
    
        // Devolver la vista pasando los datos
        return view('productos.verproducto', compact('producto', 'fechas_reservadas'));
    }
    /**
     * Eliminar un registro
     */
    public function destroy(Producto $producto){
        $producto->delete();
        $user_id = Auth::id();
        $productosDelUsuario = Producto::where('id_usuario', $user_id)->get();

        return view('productos.usuario',compact('productosDelUsuario'));
    }


    public function novedades(Request $request){
        
        $productos = Producto::orderBy('created_at', 'desc')->paginate(10);
    
        if ($request->ajax()) {
            // Si la solicitud es AJAX, devolver el HTML y si hay más páginas
            return response()->json([
                'html' => view('productos.novedades_data', compact('productos'))->render(),
                'next_page' => $productos->hasMorePages() ? true : false
            ]);
        }
    
        // Si la solicitud no es AJAX, devolver la vista estándar
        return view('productos.novedades', compact('productos'));
    }

    public function ofertas(Request $request){

        // Filtrar productos con descuento en el campo 'descuento'
        $productos = Producto::whereHas('caracteristicas', function ($query) {
            // Verificar que exista un descuento (se asume que el campo 'descuento' está en la tabla 'caracteristicas')
            $query->whereNotNull('descuento')->where('descuento', '>', 0);
        })->orderBy('created_at', 'desc')->paginate(10);
    
        if ($request->ajax()) {
            // Si la solicitud es AJAX, devolver el HTML y si hay más páginas
            return response()->json([
                'html' => view('productos.ofertas_data', compact('productos'))->render(),
                'next_page' => $productos->hasMorePages() ? true : false
            ]);
        }
    
        // Si la solicitud no es AJAX, devolver la vista estándar
        return view('productos.ofertas', compact('productos'));
    }
    
    
    public function valoraciones(Request $request){
        
        $productos = Producto::orderBy('valoracion_media', 'desc')->paginate(10);
    
        if ($request->ajax()) {
            // Si la solicitud es AJAX, devolver el HTML y si hay más páginas
            return response()->json([
                'html' => view('productos.novedades_data', compact('productos'))->render(),
                'next_page' => $productos->hasMorePages() ? true : false
            ]);
        }
    
        // Si la solicitud no es AJAX, devolver la vista estándar
        return view('productos.valoraciones', compact('productos'));
    }

    public function mostrarFormularioReserva(Producto $producto)
    {
        // Obtener todas las reservas futuras para el producto
        $reservas = Alquiler::where('id_producto', $producto->id)
            ->where('fecha_inicio', '>=', now())  // Solo reservas futuras
            ->get();

        // Formatear las fechas de inicio de las reservas para usar en el calendario
        $fechas_reservadas = $reservas->map(function ($reserva) {
            return Carbon::parse($reserva->fecha_inicio)->format('Y-m-d');  // Solo la fecha de inicio
        });

        // Pasar las fechas reservadas al frontend
        return view('productos.reservar', [
            'producto' => $producto,
            'fechas_reservadas' => $fechas_reservadas
        ]);
    }

    public function actualizarReserva(Request $request, Producto $producto)
    {
        $request->validate([
            'fecha_rango' => 'required|string',
        ]);
    
        $fecha_rango = $request->fecha_rango;
        if (strpos($fecha_rango, 'to') !== false) {
            $rango_fechas = explode(" to ", $fecha_rango);
            $fecha_inicio = Carbon::parse($rango_fechas[0]);
            $fecha_fin = Carbon::parse($rango_fechas[1]);
            $is_range = true;
        } else {
            $fecha_inicio = Carbon::parse($fecha_rango);
            $fecha_fin = $fecha_inicio;
            $is_range = false;
        }
    
        // Crear el alquiler en la base de datos
        Alquiler::create([
            'id_producto' => $producto->id,
            'id_arrendador' => $producto->id_usuario,
            'id_arrendatario' => auth()->user()->id,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'precio_total' => $request->precio_total, // Puedes pasar el precio calculado desde el formulario si es necesario
            'is_range' => $is_range,
        ]);
    
        return redirect()->route('productos.verproducto', $producto)->with('success', 'Reserva realizada con éxito');
    }
    
}

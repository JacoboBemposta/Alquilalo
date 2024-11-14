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
use App\Models\Valoracion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class ProductoController extends Controller
{

    /**
     * Devuelve la vista de productos ordenados
     * por novedades y por descuentos
     */
    public function index()
    {

        // Obtener productos ordenados por fecha
        $productosPorFecha = Producto::orderBy('created_at', 'desc')->get();

        // Obtener productos ordenados por descuento (de mayor a menor)
        $productosPorDescuento = Producto::whereHas('caracteristicas', function ($query) {
            $query->where('descuento', '>', 0);
        })
            ->with('caracteristicas')
            ->get()
            ->sortByDesc(function ($producto) {
                return $producto->caracteristicas ? $producto->caracteristicas->descuento : 0;
            });
        $productosOrdenados = $productosPorDescuento->sortByDesc(function ($producto) {
            return $producto->caracteristicas ? $producto->caracteristicas->descuento : 0;
        });

        // Si quieres que el resultado sea una colección y no se altere el original
        $productosPorDescuento = $productosOrdenados->values();

        $productosPorValoracion = Producto::orderByDesc('valoracion_media')->get();

        return view('productos.index', compact('productosPorFecha', 'productosPorDescuento', 'productosPorValoracion'));
    }

    /**
     * Devuelve la vista del formulario para dar de alta un producto.
     */
    public function create()
    {
        $categorias = Categoria::with('subcategorias')->get();
        $user_id = Auth::id();
        return view('productos.crear', compact('categorias', 'user_id'));
    }

    /**
     * Almacenar productos en la bdd.
     */
    public function store(Request $request)
    {
        // Crear el producto
        $producto = Producto::create($request->only('id_categoria', 'id_subcategoria', 'id_usuario', 'nombre', 'descripcion', 'precio_dia', 'precio_semana', 'precio_mes', 'disponible'));
        // Manejar las imágenes
        Caracteristica::create([
            'id_producto' => $producto->id,
            'novedad' => 1,
            'descuento' => $request->descuento,
            'descripcion' => $request->descripcionlarga,
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

        return view('productos.usuario', compact('productosDelUsuario'));
    }

    public function misproductos()
    {
        $user_id = Auth::id();
        // Obtener todos los productos del usuario logeado
        $productosDelUsuario = Producto::where('id_usuario', $user_id)->get();

        // Array para almacenar el total de alquileres de cada producto
        $totales_alquiler = [];

        foreach ($productosDelUsuario as $producto) {
            // Obtener todas las reservas del producto actual
            $reservas = Alquiler::where('id_producto', $producto->id)->get();

            // Variable para acumular el precio total de los alquileres de este producto
            $total_alquiler = 0;

            foreach ($reservas as $reserva) {
                // Sumar el precio_total de esta reserva al acumulador
                $total_alquiler += $reserva->precio_total;
            }

            // Guardar el total de alquileres de este producto en el array usando el ID del producto como clave
            $totales_alquiler[$producto->id] = $total_alquiler;
        }

        // Devolver la vista pasando los datos de productos y totales de alquileres
        return view('productos.usuario', compact('productosDelUsuario', 'totales_alquiler'));
    }


    public function actualizar(Producto $producto)
    {
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
    public function edit(Request $request)
    {
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
        $user_id = Auth::id(); // ID del usuario autenticado

        // Verificar si el usuario ha alquilado el producto y si la fecha de inicio es mayor o igual a hoy
        $alquilerActivo = Alquiler::where('id_producto', $producto->id)
            ->where('id_arrendatario', $user_id)
            ->whereDate('fecha_inicio', '>=', Carbon::today())
            ->exists();

        // Obtener valoraciones del producto con la relación del usuario
        $valoraciones = Valoracion::where('id_producto', $producto->id)
            ->with('usuario')  // Asumiendo que tienes una relación `usuario` en Valoracion
            ->get();
        // Devolver la vista pasando los datos, incluyendo la suma de precio_total
        return view('productos.verproducto', compact('producto', 'fechas_reservadas', 'alquilerActivo', 'valoraciones'));
    }
    /**
     * Eliminar un registro
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        $user_id = Auth::id();
        $productosDelUsuario = Producto::where('id_usuario', $user_id)->get();

        return view('productos.usuario', compact('productosDelUsuario'));
    }


    public function novedades(Request $request)
    {

        $productos = Producto::orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            // Si la solicitud es AJAX, devolver el HTML y si hay más páginas
            return response()->json([
                'html' => view('productos.data', compact('productos'))->render(),
                'next_page' => $productos->hasMorePages() ? true : false
            ]);
        }

        // Si la solicitud no es AJAX, devolver la vista estándar
        return view('productos.novedades', compact('productos'));
    }

    public function ofertas(Request $request)
    {
        // Filtrar productos con descuento en el campo 'descuento' y ordenarlos por descuento
        $productos = Producto::whereHas('caracteristicas', function ($query) {
            // Verificar que exista un descuento (se asume que el campo 'descuento' está en la tabla 'caracteristicas')
            $query->whereNotNull('descuento')->where('descuento', '>', 0);
        })
            ->join('caracteristicas', 'productos.id', '=', 'caracteristicas.id_producto') // Realiza un join con la tabla 'caracteristicas'
            ->orderBy('caracteristicas.descuento', 'desc') // Ordena por el campo 'descuento' de la tabla 'caracteristicas'
            ->paginate(10);

        if ($request->ajax()) {
            // Si la solicitud es AJAX, devolver el HTML y si hay más páginas
            return response()->json([
                'html' => view('productos.datadesc', compact('productos'))->render(),
                'next_page' => $productos->hasMorePages() ? true : false
            ]);
        }

        // Si la solicitud no es AJAX, devolver la vista estándar
        return view('productos.ofertas', compact('productos'));
    }


    public function valoraciones(Request $request)
    {

        $productos = Producto::orderBy('valoracion_media', 'desc')->paginate(10);

        if ($request->ajax()) {
            // Si la solicitud es AJAX, devolver el HTML y si hay más páginas
            return response()->json([
                'html' => view('productos.data', compact('productos'))->render(),
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
        $producto->acumulado += $request->precio_total;
        $producto->save();
        return redirect()->route('productos.verproducto', $producto)->with('success', 'Reserva realizada con éxito');
    }

    // app/Http/Controllers/ProductoController.php

    public function obtenerAlquileres($productoId)
    {
        $producto = Producto::find($productoId);

        if ($producto) {
            $alquileres = $producto->alquileres;
            return response()->json($alquileres);
        }

        return response()->json([], 404);
    }





    public function buscar(Request $request)
    {
        // Obtener la consulta de búsqueda
        $query = $request->input('query');

    
        $productos = Producto::where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('nombre', 'like', "%$query%")
                             ->orWhere('descripcion', 'like', "%$query%");
            })
            ->orWhere(function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('subcategoria', function ($queryBuilder) use ($query) {
                    $queryBuilder->where('nombre', 'like', "%$query%");
                })
                ->orWhereHas('caracteristicas', function ($queryBuilder) use ($query) {
                    $queryBuilder->where('descripcion', 'like', "%$query%");
                });
            })
            ->paginate(10); // Paginación con 10 productos por página
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('productos.databuscar', compact('productos'))->render(),
                'next_page' => $productos->hasMorePages() // Indica si hay más páginas
            ]);
        }
    
        return view('productos.buscar', compact('productos'));
    }
    
    

}

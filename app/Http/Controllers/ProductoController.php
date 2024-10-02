<?php

namespace App\Http\Controllers;

use App\Models\caracteristica;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\ImagenProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller{

    /**
     * Devuelve la vista de productos ordenados
     * por novedades y por descuentos
     */
public function index()
{
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

    return view('productos.index', compact('productosPorFecha', 'productosPorDescuento'));
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
    public function actualizar(Producto $producto){
        $categorias = Categoria::with('subcategorias')->get();
        return view('productos.actualizar',compact('producto','categorias'));
    }


    public function show(Producto $producto)
    {
        //
    }

        /**
     * Actualizar datos de un producto
     */
    public function edit(Request $request){
        $producto=Producto::find($request->id_producto);
        $producto->id_categoria=$request->id_categoria;
        $producto->id_subcategoria=$request->id_subcategoria;
        $producto->descripcion=$request->descripcion;
        $producto->precio_dia=$request->precio_dia;
        $producto->precio_semana=$request->precio_semana;
        $producto->precio_mes=$request->precio_mes;
        $producto->save();
        if ($producto->caracterisiticas) {
            $producto->caracterisiticas->descuento = $request->descuento;
            $producto->caracterisiticas->descripcion = $request->descripcionlarga;
            $producto->caracterisiticas->save();
        }
        $imagenesPrevias = ImagenProducto::where('id_producto', $producto->id)->get();
        foreach ($imagenesPrevias as $imagenPrevia) {
            Storage::disk('public')->delete($imagenPrevia->ruta_imagen);
            $imagenPrevia->delete();
        }
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


    public function update(Request $request, Producto $producto)
    {
        //
    }
    /**
     * Ver un registro
     */
    public function verproducto(Producto $producto){


        return view('productos.verproducto',compact('producto'));
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
    public function novedades(){

        $productos = Producto::orderBy('created_at', 'desc')->get();
        
        return view('productos.novedades',compact('productos'));
    }
}

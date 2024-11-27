<?php

use App\Http\Controllers\AlquilerController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\userController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\EntregaRecogidaController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/contact', function() {
    return view('contact'); // Vista con el formulario de contacto
});

Route::post('/contact', [ContactController::class, 'sendContactEmail'])->name('contact.send');


Route::controller(IndexController::class)->group(function(){
    Route::get('/', indexController::class);
    Route::get('/home', indexController::class);    
});



Route::get('/alquileres/arrendatario/{id_usuario}', [AlquilerController::class, 'alquileresPorArrendatario'])->middleware('auth');
Route::get('/alquileres/arrendador/{id_usuario}', [AlquilerController::class, 'alquileresPorArrendador'])->middleware('auth');
Auth::routes();

Route::get('/categorias', [CategoriaController::class,'index'])->name('categorias.index');
Route::get('/perfil', [UserController::class, 'show'])->name('perfil')->middleware('auth');


Route::get('/subcategorias/{categoria_id}', [CategoriaController::class, 'getSubcategorias']);

Route::get('/productos.create', [ProductoController::class, 'create'])->name('productos.create')->middleware('auth');
Route::get('/productos/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');
Route::post('/productos/store', [ProductoController::class, 'store'])->name('productos.store')->middleware('auth');
Route::get('/productos/index', [ProductoController::class, 'index'])->name('productos.index'); 
Route::post('/productos/actualizar/{producto}', [ProductoController::class, 'actualizar'])->name('productos.actualizar')->middleware('auth');
Route::post('/productos/edit', [ProductoController::class, 'edit'])->name('productos.edit')->middleware('auth'); 
Route::get('/productos/misproductos', [ProductoController::class, 'misproductos'])->name('productos.misproductos')->middleware('auth'); 
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.eliminar')->middleware('auth');
Route::get('/productos/verproducto/{producto}', [ProductoController::class, 'verproducto'])->name('productos.verproducto');
Route::get('/productos/novedades', [ProductoController::class, 'novedades'])->name('productos.novedades');
Route::get('/productos/ofertas', [ProductoController::class, 'ofertas'])->name('productos.ofertas');
Route::get('/productos/valoraciones', [ProductoController::class, 'valoraciones'])->name('productos.valoraciones');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
//     Route::post('/productos/store', [ProductoController::class, 'store'])->name('productos.store');
// });
Route::view('/general/preguntas', 'general.preguntas');
Route::view('/general/comofunciona', 'general.comofunciona');
Route::view('/general/contactanos', 'general.contactanos');
Route::view('/general/normas', 'general.normas');
Route::view('/general/quienessomos', 'general.quienessomos');
Route::view('/general/avisolegal', 'general.avisolegal');
Route::view('/general/condicionesuso', 'general.condicionesuso');
Route::view('/general/politica', 'general.politica');


Route::get('/subcategoria/{id}', [SubcategoriaController::class, 'index'])->name('subcategoria.index');

Route::post('/productos/{producto}/reservar', [ProductoController::class, 'actualizarReserva'])->name('productos.actualizarReserva')->middleware('auth');
Route::get('/productos/{producto}/alquileres', [ProductoController::class, 'obtenerAlquileres'])->name('productos.obtenerAlquileres')->middleware('auth');


Route::get('/alquileres/{id}/edit/{id_producto}', [AlquilerController::class, 'edit'])->name('alquileres.edit')->middleware('auth');
Route::delete('/alquileres/{id}/cancel', [AlquilerController::class, 'cancelar'])->name('alquileres.cancel')->middleware('auth');
Route::put('/alquileres/{id}', [AlquilerController::class, 'update'])->name('alquileres.update')->middleware('auth');

Route::post('/valoraciones/guardar', [ValoracionController::class, 'guardar'])->name('valoraciones.guardar')->middleware('auth');

Route::get('/publicar-oferta', [ItemController::class, 'index'])->name('ofertas.index')->middleware('auth'); // Ver listado
Route::post('/publicar-oferta', [ItemController::class, 'store'])->name('ofertas.store')->middleware('auth'); // Crear nuevo item
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy')->middleware('auth');

Route::get('/presentacion', function () {
    return view('general.presentacion');
});


Route::get('/pagos/detalles/{id}', [PagoController::class, 'detalles'])->name('pagos.detalles');
Route::post('/incidencias', [IncidenciaController::class, 'store'])->name('incidencias.store');



Route::post('/entregas-recogidas', [EntregaRecogidaController::class, 'registrarEvento'])->name('entregas-recogidas.registrar');
Route::get('/entregas-recogidas/{alquiler_id}', [EntregaRecogidaController::class, 'obtenerEventos'])->name('entregas-recogidas.obtener');
Route::get('/productos/{productoId}/estados', [ProductoController::class, 'verEstadosProducto'])->name('productos.ver_estados');


Route::get('/admin/alquileres', [AdminController::class, 'index'])->name('admin.alquileres');
Route::get('/alquileres/{id}', [AdminController::class, 'detallesAlquiler'])->name('admin.detalles_alquiler');
Route::get('/alquileres/gestionar', [AlquilerController::class, 'gestionarAlquileres'])->name('admin.gestionar_alquileres');
Route::put('/alquileres/cambiar_estado/{id}', [AlquilerController::class, 'cambiarEstado'])->name('admin.cambiar_estado');


Route::get('/proxy/spanish', function () {
    return file_get_contents('https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json');
});
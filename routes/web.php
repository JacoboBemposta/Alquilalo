<?php

use App\Http\Controllers\AlquilerController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SubcategoriaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\ContactController;

Route::get('/contact', function() {
    return view('contact'); // Vista con el formulario de contacto
});

Route::post('/contact', [ContactController::class, 'sendContactEmail'])->name('contact.send');


Route::controller(IndexController::class)->group(function(){
    Route::get('/', indexController::class);
    Route::get('/home', indexController::class);    
});



Route::get('/alquileres/arrendatario/{id_usuario}', [AlquilerController::class, 'alquileresPorArrendatario']);
Route::get('/alquileres/arrendador/{id_usuario}', [AlquilerController::class, 'alquileresPorArrendador']);
Auth::routes();

Route::get('/categorias', [CategoriaController::class,'index'])->name('categorias.index');
Route::get('/perfil', [UserController::class, 'show'])->name('perfil');


Route::get('/subcategorias/{categoria_id}', [CategoriaController::class, 'getSubcategorias']);

Route::get('/productos.create', [ProductoController::class, 'create'])->name('productos.create');
Route::get('/productos/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');
Route::post('/productos/store', [ProductoController::class, 'store'])->name('productos.store'); 
Route::get('/productos/index', [ProductoController::class, 'index'])->name('productos.index'); 
Route::post('/productos/actualizar/{producto}', [ProductoController::class, 'actualizar'])->name('productos.actualizar'); 
Route::post('/productos/edit', [ProductoController::class, 'edit'])->name('productos.edit'); 
Route::get('/productos/misproductos', [ProductoController::class, 'misproductos'])->name('productos.misproductos'); 
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.eliminar');
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

Route::post('/productos/{producto}/reservar', [ProductoController::class, 'actualizarReserva'])->name('productos.actualizarReserva');
Route::get('/productos/{producto}/alquileres', [ProductoController::class, 'obtenerAlquileres'])->name('productos.obtenerAlquileres');


Route::get('/alquileres/{id}/edit/{id_producto}', [AlquilerController::class, 'edit'])->name('alquileres.edit');
Route::delete('/alquileres/{id}/cancel', [AlquilerController::class, 'cancelar'])->name('alquileres.cancel');
Route::put('/alquileres/{id}', [AlquilerController::class, 'update'])->name('alquileres.update');

Route::post('/valoraciones/guardar', [ValoracionController::class, 'guardar'])->name('valoraciones.guardar');

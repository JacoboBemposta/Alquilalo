<?php

use App\Http\Controllers\AlquilerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CaracteristicaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductoController;
use App\Models\caracteristica;
use App\Models\Subcategoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::controller(IndexController::class)->group(function(){
    Route::get('/', indexController::class);
    Route::get('/home', indexController::class);    
});



Route::get('/alquileres/arrendatario/{id_usuario}', [AlquilerController::class, 'alquileresPorArrendatario']);
Route::get('/alquileres/arrendador/{id_usuario}', [AlquilerController::class, 'alquileresPorArrendador']);
Auth::routes();

Route::get('/categorias', [CategoriaController::class,'index'])->name('categorias.index');

Route::get('/subcategorias/{categoria_id}', [CategoriaController::class, 'getSubcategorias']);

Route::get('/productos.create', [ProductoController::class, 'create'])->name('productos.create');
Route::post('/productos/store', [ProductoController::class, 'store'])->name('productos.store'); 
Route::get('/productos/index', [ProductoController::class, 'index'])->name('productos.index'); 
Route::post('/productos/actualizar/{producto}', [ProductoController::class, 'actualizar'])->name('productos.actualizar'); 
Route::post('/productos/edit', [ProductoController::class, 'edit'])->name('productos.edit'); 
Route::get('/productos/misproductos', [ProductoController::class, 'misproductos'])->name('productos.misproductos'); 
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.eliminar');
Route::get('/productos/verproducto/{producto}', [ProductoController::class, 'verproducto'])->name('productos.verproducto');
Route::get('/productos.novedades', [ProductoController::class, 'novedades'])->name('productos.novedades');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
//     Route::post('/productos/store', [ProductoController::class, 'store'])->name('productos.store');
// });
Route::view('/general/preguntas', 'general.preguntas');

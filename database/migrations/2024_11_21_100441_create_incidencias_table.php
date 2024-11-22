<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciasTable extends Migration
{
    public function up()
    {
        // Creamos la tabla incidencias
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();  // Crea el campo id como clave primaria
            $table->unsignedBigInteger('alquiler_id');  // Relación con el alquiler
            $table->text('descripcion');  // Descripción de la incidencia
            $table->string('ruta_imagen')->nullable();  // Columna para la ruta de la imagen
            $table->boolean('resuelta')->default(false);  // Estado de aprobación de la incidencia
            $table->timestamps();  // Fechas de creación y actualización
    
            // Definimos la clave foránea
            $table->foreign('alquiler_id')
                  ->references('id')  // Hace referencia a la columna id en la tabla alquileres
                  ->on('alquilers')
                  ->onDelete('cascade');  // En caso de eliminar un alquiler, eliminar las incidencias asociadas
        });
    }
    
    public function down()
    {
        // Eliminamos la tabla incidencias
        Schema::dropIfExists('incidencias');
    }
    
}

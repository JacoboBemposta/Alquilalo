<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Campo user_id
            $table->string('nombre');
            $table->text('descripcion');
            $table->boolean('visible')->default(false);
            $table->timestamps();

            // Definir la clave foránea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Eliminar la clave foránea antes de eliminar la tabla
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('items');
    }
};

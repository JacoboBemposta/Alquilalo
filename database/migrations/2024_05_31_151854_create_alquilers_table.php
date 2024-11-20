<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alquilers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_arrendador');
            $table->unsignedBigInteger('id_arrendatario');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->boolean('is_range')->default(false);
            $table->decimal('precio_total', 8, 2)->nullable(); 
            $table->decimal('fianza', 10, 2)->default(0);
            $table->string('transaction_id')->nullable();
            $table->timestamps();
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('id_arrendador')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_arrendatario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquilers');
    }
};

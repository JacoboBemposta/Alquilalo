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
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal('fianza', 10, 2)->default(0)->after('disponible');  // Añadimos el campo fianza
        });
    }
    
    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('fianza');
        });
    }
};

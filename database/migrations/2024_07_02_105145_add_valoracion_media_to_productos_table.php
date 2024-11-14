<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(){
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal('valoracion_media', 3, 2)->default(3.5);
        });
    }

public function down(){
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('valoracion_media');
        });
    }
};

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
        Schema::table('alquilers', function (Blueprint $table) {
            $table->string('transaction_id',255)->nullable(); // O puedes agregar unique() si quieres que sea único
        });
    }
    
    public function down()
    {
        Schema::table('alquilers', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
};

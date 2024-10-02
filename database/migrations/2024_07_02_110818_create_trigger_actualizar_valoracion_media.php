<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(){
        DB::unprepared(file_get_contents(database_path('migrations/create_trigger.sql')));
    }

public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS actualizar_valoracion_media');
    }   
};

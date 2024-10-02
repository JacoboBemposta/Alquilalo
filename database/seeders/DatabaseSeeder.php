<?php

namespace Database\Seeders;

use App\Models\Alquiler;
use App\Models\caracteristica;
use App\Models\Categoria;
use App\Models\Favorito;
use App\Models\ImagenProducto;
use App\Models\Producto;
use App\Models\Subcategoria;
use App\Models\User;
use App\Models\Valoracion;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();
        Categoria::factory(10)->
            has(Subcategoria::factory(5)->
                has(Producto::factory(10)))->create();
        Alquiler::factory(20)->create();
        Favorito::factory(5)->create();
        Valoracion::factory(25)->create();
        ImagenProducto::factory(20)->create();
        caracteristica::factory(20)->create();
    }
}

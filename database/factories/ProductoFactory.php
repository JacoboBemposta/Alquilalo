<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'id_categoria' => \App\Models\Categoria::inRandomOrder()->first()->id,
            'id_usuario' => \App\Models\User::inRandomOrder()->first()->id,
            'id_subcategoria' => \App\Models\Subcategoria::inRandomOrder()->first()->id,
            'nombre' => fake()->name(),
            'descripcion' => fake()->text(),
            'precio_dia' => fake() -> randomFloat(2, 10, 1000),
            'precio_semana' => fake() -> randomFloat(2, 30, 3000),
            'precio_mes' => fake() -> randomFloat(2, 50, 5000),
            'disponible' => fake()->boolean()
        ];
    }
}



<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Valoracion>
 */
class ValoracionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_usuario' => \App\Models\User::inRandomOrder()->first()->id,
            'id_producto' => fake()->numberBetween(1,20),
            'descripcion' => fake()->text(),
            'puntuacion' => fake()->numberBetween(1,5),
            'ruta_imagen' => fake()->url()
            
        ];
    }
}

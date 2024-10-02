<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alquiler>
 */
class AlquilerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        return [
            'id_producto' => fake()->numberBetween(1,20),
            'id_arrendador' => fake()->numberBetween(1,20),
            'id_arrendatario' => fake()->numberBetween(1,20),
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->date(),
            'precio_total' => fake()->randomFloat(2, 50, 5000),
        ];
    }
}



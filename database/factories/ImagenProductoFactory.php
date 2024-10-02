<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ImagenProducto>
 */
class ImagenProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_producto' => fake()->numberBetween(1,100),
            'nombre' => fake()->name(),
            'ruta_imagen' =>fake()->url()
        ];
    }
}

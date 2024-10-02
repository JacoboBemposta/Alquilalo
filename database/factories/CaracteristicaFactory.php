<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Caracteristica>
 */
class CaracteristicaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $producto = Producto::inRandomOrder()->first(); // Obtener un producto aleatorio
        $categoria = $producto->categoria->nombre; // Asumir que el modelo Producto tiene una relación con Categoría

        $attributes = [
            'id_producto' => $producto->id,
            'novedad' => $this->faker->boolean(),
            'descripcion' => $this->faker->text(),
            'descuento' => $this->faker->randomFloat(2, 0, 75),
        ];


        return $attributes;
    }
}

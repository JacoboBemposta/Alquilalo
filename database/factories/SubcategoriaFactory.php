<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subcategoria>
 */
class SubcategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subcat = ['subcategoria1', 'subcategoria2', 'subcategoria3', 'subcategoria4', 'subcategoria5'];
        return [
            'nombre' => $this->faker->randomElement($subcat),
            'id_categoria' => fake()->numberBetween(1,100),
        ];
    }
}

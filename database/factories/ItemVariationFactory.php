<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemVariation>
 */
class ItemVariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_size' => fake()->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'item_price' => fake()->randomFloat(2, 7, 150),
        ];
    }
}

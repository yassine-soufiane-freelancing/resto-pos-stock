<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_status' => fake()->randomElement([
                OrderStatus::COMPLETED(),
                OrderStatus::PENDING(),
                OrderStatus::RETURNED(),
            ]),
            'is_paid' => fake()->boolean(),
            'payment_type' => fake()->randomElement([
                'cash',
                'card',
            ]),
            'order_discount' => fake()->numberBetween(0, 20),
        ];
    }
}

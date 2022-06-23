<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'pawn_id' => rand(1, 2),
            'village_id' => rand(1, 5),
            'owner_id' => rand(1, 4),
            'weight' => rand(100, 1000),
            // 'price' => rand(10000, 1000000),
            'note' => $this->faker->paragraph(),
        ];
    }
}

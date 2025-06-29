<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ten' => $this->faker->randomElement(['Gấu bông nhỏ', 'Gấu bông trung', 'Gấu bông lớn', 'Gấu bông cao cấp', 'Gấu bông trẻ em']),
            'mieu_ta' => $this->faker->sentence(),
            'trang_thai' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}

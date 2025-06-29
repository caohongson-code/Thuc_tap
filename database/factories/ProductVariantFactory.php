<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_sanpham' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'kich_co' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'gia' => $this->faker->randomFloat(2, 30, 600),
            'tonkho' => $this->faker->numberBetween(0, 100),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_giohang' => Cart::inRandomOrder()->first()->id ?? Cart::factory(),
            'id_sanpham' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'id_bien' => ProductVariant::inRandomOrder()->first()->id ?? ProductVariant::factory(),
            'gia' => $this->faker->randomFloat(2, 50, 500),
            'tong_gia' => $this->faker->randomFloat(2, 100, 2000),
        ];
    }
}

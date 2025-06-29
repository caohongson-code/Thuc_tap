<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_dathang' => Order::inRandomOrder()->first()->id ?? Order::factory(),
            'id_sanpham' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'id_bienthe' => ProductVariant::inRandomOrder()->first()->id ?? ProductVariant::factory(),
            'soluong' => $this->faker->numberBetween(1, 5),
            'gia' => $this->faker->randomFloat(2, 50, 500),
            'tong_gia' => $this->faker->randomFloat(2, 100, 2000),
        ];
    }
}

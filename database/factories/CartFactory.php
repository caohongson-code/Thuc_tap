<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'id_KH' => User::inRandomOrder()->first()->id ?? User::factory(),
            'id_sanpham' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'tong_mathang' => $this->faker->numberBetween(1, 5),
            'tong_gia' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}

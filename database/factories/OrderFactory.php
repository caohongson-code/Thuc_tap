<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
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
            'id_giohang' => Cart::inRandomOrder()->first()->id ?? Cart::factory(),
            'id_KH' => User::inRandomOrder()->first()->id ?? User::factory(),
            'ten' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'dien_thoai' => $this->faker->phoneNumber(),
            'tong_mathang' => $this->faker->numberBetween(1, 5),
            'tong_gia' => $this->faker->randomFloat(2, 100, 2000),
            'dia_chi' => $this->faker->address(),
            'vanchuyen_thanhpho' => $this->faker->city(),
            'trangthai' => $this->faker->randomElement(['choxuly', 'danggiao', 'dagiao', 'huy']),
        ];
    }
}

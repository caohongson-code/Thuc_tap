<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phuongthuc_thanhtoan' => $this->faker->randomElement(['cash', 'bank_transfer', 'credit_card', 'momo', 'zalopay']),
            'trangthai_thanhtoan' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'sotien_thanhtoan' => $this->faker->randomFloat(2, 100, 2000),
            'ngay_thanh_toan' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

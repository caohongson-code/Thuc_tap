<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_danhmuc' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'ten_san_pham' => $this->faker->company(),
            'mota' => $this->faker->paragraph(),
            'ma_hang' => $this->faker->unique()->ean8(),
            'gia_coso' => $this->faker->randomFloat(2, 50, 500),
            'trang_thai' => $this->faker->randomElement(['active', 'inactive']),
            'hinhanh' => $this->faker->imageUrl(640, 480, 'animals', true),
        ];
    }
}

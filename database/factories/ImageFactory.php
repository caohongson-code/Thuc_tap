<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anh' => $this->faker->imageUrl(640, 480, 'animals', true),
            'id_sanpham' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'mo_ta' => $this->faker->optional()->sentence(),
            'loai' => $this->faker->randomElement(['main', 'gallery']),
        ];
    }
}

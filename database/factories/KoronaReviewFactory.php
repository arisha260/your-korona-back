<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class KoronaReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();

        return [
            'product_id' => $product->id,
            'description' => $this->faker->paragraph(3),
            'slug' => Str::slug($this->faker->words(3, true)),
            'author' => $this->faker->name(),
            'mark' => 5,
            'likes' => rand(0, 200),
        ];
    }
}

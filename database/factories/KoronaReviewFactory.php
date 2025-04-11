<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        $photos = json_decode($product->photos, true);
        $firstImage = $photos[0] ?? 'images/reviews/default.jpg';

        return [
            'product_id' => $product->id,
            'description' => $this->faker->paragraph(3),
            'author' => $this->faker->name(),
            'mark' => 5,
            'likes' => rand(0, 200),
            'img' => $firstImage,
        ];
    }
}

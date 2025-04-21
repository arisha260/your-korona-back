<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $photos = [
            'images/card-image-1.png',
            'images/card-image-2.png',
            'images/card-image-3.png',
            'images/card-image-4.png',
            'images/card-image-5.png',
        ];

        return [
            'title' => $this->faker->words(3, true),
            'slug' => Str::slug($this->faker->words(3, true)),
            'description' => $this->faker->paragraph(3),
            'photos' => $photos,
            'category_id' => rand(1, 7),
            'actual_price' => rand(1000, 9000),
            'old_price' => rand(1000, 11000),
            'equipment' => json_encode([
                $this->faker->word(),
                $this->faker->word(),
                $this->faker->word()
            ]),
            'external_links' => json_encode([
                'instagram' => 'https://instagram.com/' . $this->faker->userName,
                'youtube' => 'https://youtube.com/' . $this->faker->slug
            ]),
            'quantity' => rand(1, 20),
            'views' => rand(0, 300),
//            'isNew' => false,
        ];
    }
}

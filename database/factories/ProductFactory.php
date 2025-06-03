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
    public function definition(): array
    {
        $photos = [
            'cover/products/product.png',
            'cover/products/product1.png',
            'cover/products/product2.png',
            'cover/products/product3.png',
            'cover/products/product4.png',
        ];

        return [
            'title' => $this->faker->words(3, true),
            'slug' => Str::slug($this->faker->words(3, true)),
            'description' => $this->faker->paragraph(3),
            'photos' => $photos,
            'category_id' => rand(1, 7),
            'actual_price' => rand(1000, 9000),
            'old_price' => rand(1000, 11000),
            'equipment' => [
                'included' => fake()->words(2),
                'excluded' => fake()->boolean() ? fake()->words(2) : [],
            ],
            'external_links' => [
                'whatsapp' => 'https://whatsapp.com/',
                'vk' => 'https://vk.com/',
                'telegram' => 'https://telegram.org/',
            ],
            'quantity' => rand(1, 20),
            'views' => rand(0, 300),
//            'isNew' => false,
        ];
    }
}

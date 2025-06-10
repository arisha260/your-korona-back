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


        $previews = [
            'cover/products/preview0.png',
            'cover/products/preview1.png',
            'cover/products/preview2.png',
            'cover/products/preview3.png',
            'cover/products/preview4.jpg',
            'cover/products/preview5.jpg',
            'cover/products/preview6.jpg',
            'cover/products/preview7.jpg',
            'cover/products/preview8.jpg',
            'cover/products/preview9.jpg',
            'cover/products/preview10.jpg',
            'cover/products/preview11.jpg',
            'cover/products/preview12.jpg',
            'cover/products/preview13.jpg',
            'cover/products/preview14.jpg',
            'cover/products/preview15.jpg',
        ];

        $preview = $this->faker->randomElement($previews);

        $actualPrice = rand(1000, 9000);
        $oldPrice = rand($actualPrice, max($actualPrice + 1000, 11000));

        return [
            'title' => $this->faker->words(3, true),
            'slug' => Str::slug($this->faker->words(3, true)),
            'description' => $this->faker->paragraph(3),
            'preview' => $preview,
            'photos' => $photos,
            'category_id' => rand(1, 7),
            'actual_price' => $actualPrice,
            'old_price' => $oldPrice,
            'equipment' => fake()->words(2),
            'external_links' => [
                'vk' => 'https://vk.com/',
                'telegram' => 'https://telegram.org/',
            ],
            'quantity' => rand(1, 20),
            'views' => rand(0, 300),
//            'isNew' => false,
        ];
    }
}

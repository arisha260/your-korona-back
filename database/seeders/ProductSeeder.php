<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $products = Product::factory()->count(70)->create();
//
//        // прикрепляем материалы
//        $products->each(function ($product) {
//            // Берём случайные ID из MaterialsPolicy
//            $materialIds = Material::inRandomOrder()->limit(rand(1, 5))->pluck('id');
//
//            // прикрепляем их к продукту
//            $product->materials()->attach($materialIds);
//        });
    }
}

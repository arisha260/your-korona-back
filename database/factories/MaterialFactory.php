<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MaterialFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class koronaNewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => 'Сайт был запущен!',
            'description' => '',
            'img' => 'cover/news/news.png',
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\KoronaNew;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            "Венки",
            "Короны",
            "Ободки",
            "Браслеты",
            "Чокеры",
            "Кокошники",
            "Серьги"
        ];

        $slugs = [
            "venki",
            "korony",
            "obodki",
            "braslety",
            "chokery",
            "kokoshniki",
            "sergi"
        ];

        foreach ($names as $index => $name) {
            Category::create([
                'name' => $name,
                'slug' => $slugs[$index]
            ]);
        }
    }
}

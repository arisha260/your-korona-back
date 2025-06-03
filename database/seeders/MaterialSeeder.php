<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\KoronaNew;
use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{

    public function run(): void
    {
        Material::factory()->count(20)->create();
    }
}

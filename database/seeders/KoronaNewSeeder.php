<?php

namespace Database\Seeders;

use App\Models\KoronaNew;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KoronaNewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KoronaNew::factory()->count(60)->create();
    }
}

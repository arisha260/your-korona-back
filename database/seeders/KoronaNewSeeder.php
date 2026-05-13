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
        KoronaNew::create([
            'title' => 'Запуск сайта',
            'description' =>
                <<<TEXT
                    Этот сайт изначально создавался как дипломный проект. На разработку ушло 3 месяца с нуля, включая дизайн, фронтенд и бэкенд.

                    Сейчас на сайте могут быть некоторые баги — это неизбежно при разработке в одиночку. Но проект будет развиваться и улучшаться, чтобы обеспечить лучший пользовательский опыт и интерфейс.

                    Спасибо за использование!
                TEXT,
            'img' => 'cover/news/news.png',
        ]);
    }
}

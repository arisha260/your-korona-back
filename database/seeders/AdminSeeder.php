<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Database\Factories\AdminFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'aryoshas@yandex.ru')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'aryoshas@yandex.ru',
                'password' => Hash::make('qzjRxj_-X-LkQ8Cs7rUq'),
                'role' => UserRole::SuperAdmin,
            ]);
        }

        if (!User::where('email', 'smirnova-580@mail.ru')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'smirnova-580@mail.ru',
                'password' => Hash::make('h2W5kUj_YfSWwTL9zeaC'),
                'role' => UserRole::SuperAdmin,
            ]);
        }
    }
}

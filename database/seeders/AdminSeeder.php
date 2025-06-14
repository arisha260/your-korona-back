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
        // 1. Фиксированный админ
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'aryoshas@yandex.ru',
            'password' => Hash::make('qzjRxj_-X-LkQ8Cs7rUq'),
            'role' => UserRole::SuperAdmin,
        ]);

        echo "Super admin: {$admin->email} / password: password\n";

        // 2. Случайные админы
        $admins = User::factory()->count(9)->create();

        foreach ($admins as $admin) {
            echo "Admin created: {$admin->email} / password: password\n";
        }
    }
}

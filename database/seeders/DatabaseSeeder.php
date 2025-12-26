<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Создаем тестового пользователя (Админа)
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.ru',
            'password' => bcrypt('password'), // пароль будет: password
            'is_admin' => true,
            'username' => 'admin_boss'
        ]);

        // 2. Добавляем персонажей, привязывая их к этому админу
        \App\Models\Character::create([
            'character_name' => 'Уайлдер',
            'character_tag' => 'Ближний бой',
            'short_description' => 'Описание из прошлой лабы...',
            'full_biography' => 'Полная биография...',
            'image_path' => 'laravel/wylder.png',
            'user_id' => $admin->id, // ПРИВЯЗКА К ЮЗЕРУ
        ]);

        // Добавь остальных 4 героев по аналогии, не забывая 'user_id' => $admin->id
    }
}

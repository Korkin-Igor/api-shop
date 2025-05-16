<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'fio' => 'Иванов Иван Иваныч',
            'email' => 'admin@shop.ru',
            'is_admin' => true,
            'password' => Hash::make('QWEasd123'),
        ]);

        DB::table('users')->insert([
            'fio' => 'Иванов Иван Иваныч',
            'email' => 'user@shop.ru',
            'password' => Hash::make('password'),
        ]);
    }
}

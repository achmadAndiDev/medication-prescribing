<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dokter',
            'email' => 'dokter@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'Dokter',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Apoteker',
            'email' => 'apoteker@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'Apoteker',
            'is_active' => true,
        ]);
    }
}

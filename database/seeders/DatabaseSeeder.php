<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan ini
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun admin
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'role' => 'supervisor',
            'password' => Hash::make('admin00000'), // Pastikan Hash sudah diimpor
            'remember_token' => Str::random(10),
        ]);

        // Buat akun staff
        User::create([
            'name' => 'Staff',
            'username' => 'staff',
            'email' => 'staff@example.com',
            'email_verified_at' => now(),
            'role' => 'staff',
            'password' => Hash::make('staff00000'), // Pastikan Hash sudah diimpor
            'remember_token' => Str::random(10),
        ]);

        // Buat 10 user tambahan secara random
        User::factory(10)->create();
    }
}

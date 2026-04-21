<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Pengguna::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama_lengkap' => 'Admin',
                'password' => Hash::make('admin12345'),
                'role' => Pengguna::ROLE_ADMIN,
            ]
        );

        Pengguna::updateOrCreate(
            ['username' => 'officer'],
            [
                'nama_lengkap' => 'Officer',
                'password' => Hash::make('officer12345'),
                'role' => Pengguna::ROLE_OFFICER,
            ]
        );
    }
}

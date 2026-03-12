<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mahasiswa
        User::create([
            'name' => 'Mahasiswa User',
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        // Yayasan
        User::create([
            'name' => 'Yayasan User',
            'email' => 'yayasan@example.com',
            'password' => Hash::make('password'),
            'role' => 'yayasan',
        ]);

        // Staff
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Affiliator
        User::create([
            'name' => 'Affiliator User',
            'email' => 'affiliator@example.com',
            'password' => Hash::make('password'),
            'role' => 'affiliator',
        ]);

        // Mitra
        User::create([
            'name' => 'Mitra User',
            'email' => 'mitra@example.com',
            'password' => Hash::make('password'),
            'role' => 'mitra',
        ]);
    }
}

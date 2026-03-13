<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['label' => 'Administrator', 'redirect_to' => '/admin/dashboard']
        );

        Role::firstOrCreate(
            ['name' => 'yayasan'],
            ['label' => 'Yayasan', 'redirect_to' => '/yayasan/dashboard']
        );

        Role::firstOrCreate(
            ['name' => 'staff'],
            ['label' => 'Staff', 'redirect_to' => '/staff/dashboard']
        );

        Role::firstOrCreate(
            ['name' => 'mahasiswa'],
            ['label' => 'Mahasiswa', 'redirect_to' => '/home']
        );

        Role::firstOrCreate(
            ['name' => 'affiliator'],
            ['label' => 'Affiliator', 'redirect_to' => '/affiliator/dashboard']
        );

        Role::firstOrCreate(
            ['name' => 'mitra'],
            ['label' => 'Mitra', 'redirect_to' => '/mitra/dashboard']
        );

        $this->call([
            AdminUserSeeder::class,
            CareerProgramSeeder::class,
            FacultyProdiSeeder::class,
        ]);
    }
}

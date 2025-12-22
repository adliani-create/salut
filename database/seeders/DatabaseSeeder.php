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

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );
    }
}

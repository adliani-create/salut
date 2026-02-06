<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = [
            ['name' => 'mahasiswa', 'label' => 'Mahasiswa', 'redirect_to' => 'home'],
            ['name' => 'admin', 'label' => 'Administrator', 'redirect_to' => 'admin.dashboard'],
            ['name' => 'mitra', 'label' => 'Mitra', 'redirect_to' => 'home'],
            ['name' => 'affiliator', 'label' => 'Affiliator', 'redirect_to' => 'home'],
        ];

        $role = fake()->randomElement($roles);

        return [
            'name' => $role['name'],
            'label' => $role['label'],
            'redirect_to' => $role['redirect_to'],
        ];
    }

    /**
     * Create an admin role.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'admin',
            'label' => 'Administrator',
            'redirect_to' => 'admin.dashboard',
        ]);
    }

    /**
     * Create a mahasiswa role.
     */
    public function mahasiswa(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'mahasiswa',
            'label' => 'Mahasiswa',
            'redirect_to' => 'home',
        ]);
    }

    /**
     * Create a mitra role.
     */
    public function mitra(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'mitra',
            'label' => 'Mitra',
            'redirect_to' => 'home',
        ]);
    }

    /**
     * Create an affiliator role.
     */
    public function affiliator(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'affiliator',
            'label' => 'Affiliator',
            'redirect_to' => 'home',
        ]);
    }
}

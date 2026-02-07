<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CareerProgram;

class CareerProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Kuliah + Wirausaha',
                'description' => 'Program fokus untuk membangun bisnis dan entrepreneurship.',
            ],
            [
                'name' => 'Kuliah + Magang Kerja',
                'description' => 'Program pengalaman kerja praktis di industri.',
            ],
            [
                'name' => 'Kuliah + Skill Academy',
                'description' => 'Program pengembangan skill spesifik dan sertifikasi.',
            ],
            [
                'name' => 'Kuliah + Affiliator/Creator',
                'description' => 'Program fokus pada content creation dan digital marketing.',
            ],
        ];

        foreach ($programs as $program) {
            CareerProgram::firstOrCreate(['name' => $program['name']], $program);
        }
    }
}

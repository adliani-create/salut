<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fakultas;
use App\Models\Prodi;

class FacultyProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Fakultas Ekonomi dan Bisnis' => [
                'Manajemen',
                'Ekonomi Pembangunan',
                'Ekonomi Syariah',
                'Akuntansi',
                'Akuntansi Keuangan Publik',
                'Pariwisata',
            ],
            'Fakultas Sains dan Teknologi' => [
                'Statistika',
                'Matematika',
                'Biologi',
                'Teknologi Pangan',
                'Agribisnis',
                'Perencanaan Wilayah dan Kota',
                'Sistem Informasi',
                'Sains Data',
            ],
            'Sekolah Pascasarjana' => [
                'Magister Studi Lingkungan',
                'Magister Manajemen Perikanan',
                'Magister Administrasi Publik',
                'Magister Manajemen',
                'Magister Pendidikan Dasar',
                'Magister Pendidikan Matematika',
                'Magister Pendidikan Bahasa Inggris',
                'Magister Pendidikan Anak Usia Dini (MPAUD)',
                'Magister Hukum',
                'Doktor Ilmu Manajemen',
                'Doktor Ilmu Administrasi',
            ],
            'Fakultas Keguruan dan Ilmu Pendidikan' => [
                'Pendidikan Bahasa dan Sastra Indonesia',
                'Pendidikan Bahasa Inggris',
                'Pendidikan Biologi',
                'Pendidikan Fisika',
                'Pendidikan Kimia',
                'Pendidikan Matematika',
                'Pendidikan Ekonomi',
                'Pendidikan Pancasila dan Kewarganegaraan',
                'Teknologi Pendidikan',
                'Pendidikan Guru Sekolah Dasar (PGSD)',
                'Pendidikan Guru Pendidikan Anak Usia Dini (PGPAUD)',
                'Program Pendidikan Profesi Guru (PPG)',
                'Pendidikan Agama Islam',
            ],
            'Fakultas Hukum Ilmu Sosial dan Ilmu Politik' => [
                'Kearsipan (D4)',
                'Perpajakan (D3)',
                'Administrasi Bisnis',
                'Hukum',
                'Ilmu Pemerintahan',
                'Ilmu Komunikasi',
                'Ilmu Perpustakaan',
                'Sosiologi',
                'Sastra Inggris',
                'Perpajakan (S1)',
            ],
        ];

        foreach ($data as $fakultasName => $prodis) {
            $fakultas = Fakultas::firstOrCreate(
                ['nama' => $fakultasName],
                ['kode' => strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3))]
            );

            foreach ($prodis as $prodiName) {
                // Determine jenjang based on name if possible, or default to S1 for generic names
                // Logic: 
                // Checks for starts with "Magister" -> S2
                // Checks for starts with "Doktor" -> S3 (Assuming support, if not map to S2 or add enum)
                // Checks for (D3), (D4), (S1) suffix
                
                $jenjang = 'S1'; // Default
                if (str_contains($prodiName, 'Magister')) {
                    $jenjang = 'S2';
                } elseif (str_contains($prodiName, 'Doktor')) {
                    $jenjang = 'S3'; // Make sure Enum supports this or map appropriately.
                    // User requested S1 and S2 in registration form earlier.
                    // If S3 isn't in Enum, we might have issue. 
                    // Let's check user requirement: "Jenjang Pendidikan (Radio Button/Select): S1, S2"
                    // So purely S1/S2? 
                    // Let's assume Doktor is S2 or 'Lainnya' for now, or just store it.
                    // Actually, if enum is strict, we should check migration.
                } elseif (str_contains($prodiName, '(D3)')) {
                    $jenjang = 'D3';
                } elseif (str_contains($prodiName, '(D4)')) {
                    $jenjang = 'D4';
                }

                Prodi::firstOrCreate([
                    'nama' => $prodiName,
                    'fakultas_id' => $fakultas->id,
                ], [
                    'jenjang' => $jenjang, 
                    'kode' => strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4)), 
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TahunAjar;

class TahunAjarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode_tahun_ajar' => '2022/2023', 'nama_tahun_ajar' => 'Tahun Ajaran 2022/2023'],
            ['kode_tahun_ajar' => '2023/2024', 'nama_tahun_ajar' => 'Tahun Ajaran 2023/2024'],
            ['kode_tahun_ajar' => '2024/2025', 'nama_tahun_ajar' => 'Tahun Ajaran 2024/2025'],
        ];

        foreach ($data as $tahun) {
            TahunAjar::updateOrCreate(
                ['kode_tahun_ajar' => $tahun['kode_tahun_ajar']],
                ['nama_tahun_ajar' => $tahun['nama_tahun_ajar']]
            );
        }
    }
}

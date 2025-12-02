<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode_jurusan' => 'RPL', 'nama_jurusan' => 'Rekayasa Perangkat Lunak'],
            ['kode_jurusan' => 'TKJ', 'nama_jurusan' => 'Teknik Komputer dan Jaringan'],
            ['kode_jurusan' => 'AKL', 'nama_jurusan' => 'Akuntansi dan Keuangan Lembaga'],
            ['kode_jurusan' => 'OTKP', 'nama_jurusan' => 'Otomatisasi dan Tata Kelola Perkantoran'],
        ];

        foreach ($data as $jurusan) {
            Jurusan::updateOrCreate(
                ['kode_jurusan' => $jurusan['kode_jurusan']],
                ['nama_jurusan' => $jurusan['nama_jurusan']]
            );
        }
    }
}

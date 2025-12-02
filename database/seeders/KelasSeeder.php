<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\TahunAjar;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahun = TahunAjar::where('kode_tahun_ajar', '2024/2025')->first()
            ?? TahunAjar::orderByDesc('id')->first();

        $jurusans = Jurusan::pluck('id', 'kode_jurusan');

        $kelasData = [
            ['nama_kelas' => 'X RPL 1', 'level_kelas' => 'X', 'jurusan_code' => 'RPL'],
            ['nama_kelas' => 'X RPL 2', 'level_kelas' => 'X', 'jurusan_code' => 'RPL'],
            ['nama_kelas' => 'XI TKJ 1', 'level_kelas' => 'XI', 'jurusan_code' => 'TKJ'],
            ['nama_kelas' => 'XI TKJ 2', 'level_kelas' => 'XI', 'jurusan_code' => 'TKJ'],
            ['nama_kelas' => 'XII AKL 1', 'level_kelas' => 'XII', 'jurusan_code' => 'AKL'],
            ['nama_kelas' => 'X OTKP 1', 'level_kelas' => 'X', 'jurusan_code' => 'OTKP'],
        ];

        foreach ($kelasData as $kelas) {
            if (!isset($jurusans[$kelas['jurusan_code']]) || !$tahun) {
                continue;
            }

            Kelas::updateOrCreate(
                ['nama_kelas' => $kelas['nama_kelas']],
                [
                    'level_kelas' => $kelas['level_kelas'],
                    'jurusan_id' => $jurusans[$kelas['jurusan_code']],
                    'tahun_ajar_id' => $tahun->id,
                ]
            );
        }
    }
}

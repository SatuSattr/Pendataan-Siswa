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

        $kelasData = [];

        foreach (['RPL', 'DKV', 'TKJ'] as $jurusanCode) {
            foreach (['X', 'XI', 'XII'] as $level) {
                foreach (['1', '2'] as $urutan) {
                    $kelasData[] = [
                        'nama_kelas' => "{$level} {$jurusanCode} {$urutan}",
                        'level_kelas' => $level,
                        'jurusan_code' => $jurusanCode,
                    ];
                }
            }
        }

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

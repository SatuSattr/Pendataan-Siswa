<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\KelasDetail;
use App\Models\Siswa;
use App\Models\TahunAjar;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahun = TahunAjar::where('kode_tahun_ajar', '2024/2025')->first()
            ?? TahunAjar::orderByDesc('id')->first();

        $kelasMap = Kelas::with('jurusan')->get()->keyBy('nama_kelas');
        $jurusans = Jurusan::pluck('id', 'kode_jurusan');

        $siswas = [
            [
                'nisn' => '0067823451',
                'nama' => 'Ayu Rahmawati',
                'jenis_kelamin' => 'P',
                'jurusan_code' => 'RPL',
                'kelas_nama' => 'X RPL 1',
                'tanggal_lahir' => '2007-03-15',
                'alamat' => 'Jl. Melati No. 12, Cimahi',
            ],
            [
                'nisn' => '0067823452',
                'nama' => 'Rizky Fadillah',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'RPL',
                'kelas_nama' => 'X RPL 2',
                'tanggal_lahir' => '2007-07-02',
                'alamat' => 'Jl. Sukasari No. 8, Bandung',
            ],
            [
                'nisn' => '0067823453',
                'nama' => 'Dewi Lestari',
                'jenis_kelamin' => 'P',
                'jurusan_code' => 'TKJ',
                'kelas_nama' => 'XI TKJ 1',
                'tanggal_lahir' => '2006-11-20',
                'alamat' => 'Jl. Cibogo No. 3, Cimahi',
            ],
            [
                'nisn' => '0067823454',
                'nama' => 'Andi Setiawan',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'TKJ',
                'kelas_nama' => 'XI TKJ 2',
                'tanggal_lahir' => '2006-05-10',
                'alamat' => 'Jl. Sukamenak No. 14, Bandung',
            ],
            [
                'nisn' => '0067823455',
                'nama' => 'Putri Safitri',
                'jenis_kelamin' => 'P',
                'jurusan_code' => 'AKL',
                'kelas_nama' => 'XII AKL 1',
                'tanggal_lahir' => '2005-09-01',
                'alamat' => 'Jl. Peta No. 77, Bandung',
            ],
            [
                'nisn' => '0067823456',
                'nama' => 'Galih Pratama',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'OTKP',
                'kelas_nama' => 'X OTKP 1',
                'tanggal_lahir' => '2007-12-05',
                'alamat' => 'Jl. Cisaranten No. 21, Bandung',
            ],
        ];

        foreach ($siswas as $item) {
            if (!$tahun) {
                continue;
            }

            $jurusanId = $jurusans[$item['jurusan_code']] ?? null;
            $kelas = $kelasMap[$item['kelas_nama']] ?? null;

            if (!$jurusanId || !$kelas) {
                continue;
            }

            $siswa = Siswa::updateOrCreate(
                ['nisn' => $item['nisn']],
                [
                    'nama' => $item['nama'],
                    'jenis_kelamin' => $item['jenis_kelamin'],
                    'jurusan_id' => $jurusanId,
                    'tahun_ajar_id' => $tahun->id,
                    'tanggal_lahir' => $item['tanggal_lahir'],
                    'alamat' => $item['alamat'],
                    'foto_path' => null,
                ]
            );

            // deactivate existing active detail
            $siswa->kelasDetails()->where('status', 'aktif')->update(['status' => 'nonaktif']);

            KelasDetail::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $kelas->id,
                    'tahun_ajar_id' => $kelas->tahun_ajar_id,
                ],
                ['status' => 'aktif']
            );
        }
    }
}

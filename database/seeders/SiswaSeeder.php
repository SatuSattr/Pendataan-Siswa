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
                'nama' => 'Ahmad Sattar Fathulloh',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'RPL',
                'kelas_nama' => 'X RPL 1',
                'tanggal_lahir' => '2008-11-21',
                'alamat' => 'Sanja RT. 001/RW. 004, Kel Sanja, Kec. Citeureup, Kab. Bogor',
            ],
            [
                'nisn' => '0067823452',
                'nama' => 'Shabira Syahla Alvaliza',
                'jenis_kelamin' => 'P',
                'jurusan_code' => 'RPL',
                'kelas_nama' => 'X RPL 1',
                'tanggal_lahir' => '2008-09-17',
                'alamat' => 'Perum. Mutiara Pasir Kuda Blok B No. 14 Rt. 003/Rw. 002, Kel. Pasir Kuda, Kec. Bogor Barat.',
            ],
            [
                'nisn' => '0067823453',
                'nama' => 'Yunita Alfitriyani',
                'jenis_kelamin' => 'P',
                'jurusan_code' => 'RPL',
                'kelas_nama' => 'X RPL 2',
                'tanggal_lahir' => '2008-11-20',
                'alamat' => 'Kp. Pabuaran RT 002/RW 005, Kel. Pabuaran, Kec. Bojonggede, Kab. Bogor',
            ],
            [
                'nisn' => '0067823454',
                'nama' => 'Zia Kirana Agustin',
                'jenis_kelamin' => 'P',
                'jurusan_code' => 'RPL',
                'kelas_nama' => 'X RPL 2',
                'tanggal_lahir' => '2008-05-10',
                'alamat' => 'Perumahan Bumi Mutiara Blok C6 No. 12, RT 004/RW 003, Kel. Gunung Putri, Kec. Gunung Putri, Kab. Bogor',
            ],
            [
                'nisn' => '0067823455',
                'nama' => 'Bimasena Wiryaatmaja Yusuf',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'RPL',
                'kelas_nama' => 'XI RPL 1',
                'tanggal_lahir' => '2007-09-01',
                'alamat' => 'Jl. Raya Ciomas No. 87, RT 001/RW 006, Kel. Ciomas Rahayu, Kec. Ciomas, Kab. Bogor',
            ],
            [
                'nisn' => '0067823456',
                'nama' => 'Faiz Nabil Akram',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'RPL',
                'kelas_nama' => 'XI RPL 2',
                'tanggal_lahir' => '2007-12-05',
                'alamat' => 'Perum. Griya Bukit Jaya Blok A2 No. 9, RT 005/RW 004, Kel. Tlajung Udik, Kec. Gunung Putri, Kab. Bogor',
            ],
            [
                'nisn' => '0067823457',
                'nama' => 'Muhamad Faisal',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'RPL',
                'kelas_nama' => 'XII RPL 1',
                'tanggal_lahir' => '2005-11-03',
                'alamat' => 'Kp. Cibeureum RT 003/RW 008, Kel. Cibeureum, Kec. Dramaga, Kab. Bogor',
            ],
            [
                'nisn' => '0067823458',
                'nama' => 'Muhammad Raditya Mahendar',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'RPL',
                'kelas_nama' => 'XII RPL 2',
                'tanggal_lahir' => '2005-09-13',
                'alamat' => 'Perum. Bumi Pertiwi 2 Blok D3 No. 22, RT 006/RW 002, Kel. Cileungsi, Kec. Cileungsi, Kab. Bogor',
            ],
            [
                'nisn' => '0067823459',
                'nama' => 'Diwa Alimar Jauhar',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'DKV',
                'kelas_nama' => 'X DKV 1',
                'tanggal_lahir' => '2008-09-13',
                'alamat' => 'Jl. Melati No. 45, RT 004/RW 001, Kel. Kedung Badak, Kec. Tanah Sareal, Kota Bogor',
            ],
            [
                'nisn' => '0067823460',
                'nama' => 'Ibnu Ghali Aulia',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'DKV',
                'kelas_nama' => 'X DKV 1',
                'tanggal_lahir' => '2009-10-11',
                'alamat' => 'Kp. Sindangbarang RT 001/RW 007, Kel. Sindangbarang, Kec. Bogor Barat, Kota Bogor',
            ],
            [
                'nisn' => '0067823461',
                'nama' => 'Faqih Abdul Karim',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'DKV',
                'kelas_nama' => 'X DKV 2',
                'tanggal_lahir' => '2008-04-22',
                'alamat' => 'Perum. Bukit Cimanggu City Blok E5 No. 18, RT 002/RW 005, Kel. Cimanggu, Kec. Tanah Sareal, Kota Bogor',
            ],
            [
                'nisn' => '0067823462',
                'nama' => 'Jasmine Aulia Putri',
                'jenis_kelamin' => 'P',
                'jurusan_code' => 'DKV',
                'kelas_nama' => 'X DKV 2',
                'tanggal_lahir' => '2008-04-21',
                'alamat' => 'Jl. Raya Parung No. 112, RT 005/RW 003, Kel. Waru, Kec. Parung, Kab. Bogor',
            ],
            [
                'nisn' => '0067823463',
                'nama' => 'Fadjar Zaahir Al Mubarak',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'DKV',
                'kelas_nama' => 'XI DKV 1',
                'tanggal_lahir' => '2007-09-11',
                'alamat' => 'Perum. Cilebut Residence Blok B4 No. 11, RT 003/RW 002, Kel. Cilebut Barat, Kec. Sukaraja, Kab. Bogor',
            ],
            [
                'nisn' => '0067823464',
                'nama' => 'Hanif Imam Muttaqin',
                'jenis_kelamin' => 'L',
                'jurusan_code' => 'DKV',
                'kelas_nama' => 'XI DKV 2',
                'tanggal_lahir' => '2007-09-12',
                'alamat' => 'Jl. Raya Kedung Halang No. 56, RT 002/RW 010, Kel. Kedung Halang, Kec. Bogor Utara, Kota Bogor',
            ],
            [
                'nisn' => '0067823465',
                'nama' => 'Mikaela Avier',
                'jenis_kelamin' => 'P',
                'jurusan_code' => 'DKV',
                'kelas_nama' => 'XII DKV 1',
                'tanggal_lahir' => '2005-09-12',
                'alamat' => 'Kp. Cikaret RT 001/RW 006, Kel. Cikaret, Kec. Bogor Selatan, Kota Bogor',
            ],
            [
                'nisn' => '0067823466',
                'nama' => 'Salwa Hafshah',
                'jenis_kelamin' => 'P',
                'jurusan_code' => 'DKV',
                'kelas_nama' => 'XII DKV 2',
                'tanggal_lahir' => '2005-05-17',
                'alamat' => 'Perum. Bumi Sani Permai Blok F2 No. 7, RT 005/RW 004, Kel. Nanggewer, Kec. Cibinong, Kab. Bogor',
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

            $fotoPath = null;
            $candidatePath = public_path("images/{$item['nisn']}.png");

            if (file_exists($candidatePath)) {
                // store relative path so it can be used directly by asset()
                $fotoPath = 'images/' . basename($candidatePath);
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
                    'foto_path' => $fotoPath,
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

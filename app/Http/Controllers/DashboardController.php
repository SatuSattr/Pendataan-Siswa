<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjar;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalSiswa' => Siswa::count(),
            'totalJurusan' => Jurusan::count(),
            'totalKelas' => Kelas::count(),
            'activeTahunAjar' => TahunAjar::where('is_active', true)->first(),
        ]);
    }
}

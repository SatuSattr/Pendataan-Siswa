<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalSiswa' => Siswa::count(),
            'totalJurusan' => Jurusan::count(),
            'totalKelas' => Kelas::count(),
            'totalUsers' => User::count(),
        ]);
    }
}

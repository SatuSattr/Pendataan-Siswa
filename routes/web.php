<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin,staff')->group(function () {
        Route::post('siswa/bulk', [SiswaController::class, 'bulk'])->name('siswa.bulk');
        Route::resource('siswa', SiswaController::class);
    });

    Route::middleware('admin')->group(function () {
        Route::resource('tahun-ajar', TahunAjarController::class)->parameters(['tahun-ajar' => 'tahunAjar']);
        Route::patch('tahun-ajar/{tahunAjar}/toggle', [TahunAjarController::class, 'toggle'])->name('tahun-ajar.toggle');
        Route::post('tahun-ajar/bulk', [TahunAjarController::class, 'bulk'])->name('tahun-ajar.bulk');
        Route::post('jurusan/bulk', [JurusanController::class, 'bulk'])->name('jurusan.bulk');
        Route::post('kelas/bulk', [KelasController::class, 'bulk'])->name('kelas.bulk');
        Route::resource('jurusan', JurusanController::class);
        Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
        Route::post('users/bulk', [UserController::class, 'bulk'])->name('users.bulk');
        Route::resource('users', UserController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

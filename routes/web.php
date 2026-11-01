<?php

use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RekapController;
use App\Http\Controllers\Admin\SesiAbsensiController;
use App\Http\Controllers\Admin\PeriodeAkademikController;
use App\Http\Controllers\Admin\HariLiburController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Guru\AbsensiController;
use App\Http\Controllers\Guru\RekapController as GuruRekap;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. Halaman utama langsung todong ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Route Dashboard Utama (Halaman perantara atau pengecek role)
Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'guru') {
        return redirect()->route('guru.dashboard');
    }
    return abort(403, 'Role tidak terdaftar.');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Grouping Route Khusus Admin
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // 1. DASHBOARD ADMIN
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 2. MASTER DATA: GURU
    Route::prefix('guru')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('guru_manage');
        Route::get('/add', function () {
            return view('admin.form.guru.guru_add');
        })->name('guru.add');
        Route::post('/store', [GuruController::class, 'store'])->name('guru.store');
        Route::get('/edit/{id}', function ($id) {
            $guru = \App\Models\User::findOrFail($id);
            return view('admin.form.guru.guru_edit', compact('guru'));
        })->name('guru.edit');
        Route::put('/update/{id}', [GuruController::class, 'update'])->name('guru.update');
    });

    // 3. MASTER DATA: KELAS
    Route::prefix('kelas')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('kelas_manage');
        Route::get('/add', [KelasController::class, 'create'])->name('kelas.add');
        Route::post('/store', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::put('/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
    });

    // 4. MASTER DATA: SISWA
    Route::prefix('siswa')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('siswa_manage');
        Route::get('/add', [SiswaController::class, 'create'])->name('siswa.add');
        Route::post('/store', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::put('/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    });

    // 5. GANTI PERIODE AKADEMIK
    Route::prefix('ganti-periode')->group(function () {
        Route::get('/', [PeriodeAkademikController::class, 'index'])->name('admin.periode.index');
        Route::post('/proses', [PeriodeAkademikController::class, 'gantiPeriode'])->name('admin.periode.proses');
        Route::post('/tahun-store', [PeriodeAkademikController::class, 'storeTahun'])->name('admin.periode.tahun.store');
        Route::post('/tahun-aktifkan/{id}', [PeriodeAkademikController::class, 'aktifkanTahun'])->name('admin.periode.tahun.aktifkan');
    });

    // 6. LAPORAN
    Route::get('/rekap', [RekapController::class, 'index'])->name('admin.rekap');

    // 7. HARI LIBUR
    Route::get('/hari-libur', [HariLiburController::class, 'index'])->name('admin.libur.index');
    Route::post('/hari-libur/store', [HariLiburController::class, 'store'])->name('admin.libur.store');
    Route::get('/hari-libur/{id}/edit', [HariLiburController::class, 'edit'])->name('admin.libur.edit');
    Route::put('/hari-libur/{id}/update', [HariLiburController::class, 'update'])->name('admin.libur.update');
    Route::delete('/hari-libur/{id}', [HariLiburController::class, 'destroy'])->name('admin.libur.destroy');

    // 8. SESI ABSENSI
    Route::get('/sesi', [SesiAbsensiController::class, 'index'])->name('admin_sesi');
    Route::post('/sesi', [SesiAbsensiController::class, 'store'])->name('admin_sesi_store');
    Route::put('/sesi/{id}', [SesiAbsensiController::class, 'update'])->name('admin_sesi_update');
    Route::delete('/sesi/{id}', [SesiAbsensiController::class, 'destroy'])->name('admin_sesi_destroy');

    // 9. QR CODE
    Route::get('/admin/kelas/{id}/download-qr', [KelasController::class, 'checkOrDownloadQr'])
        ->name('admin.kelas.download-qr');
});

// 4. Grouping Route Khusus Guru
Route::middleware(['auth'])->prefix('guru')->group(function () {
    // 1. Dashboard
    Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('guru.dashboard');
    Route::get('/cek-hari-libur', [GuruDashboard::class, 'cekLibur'])->name('guru.cek-libur');

    // 2. Konfirmasi & Input Absen
    Route::get('/konfirmasi-absen', [AbsensiController::class, 'index'])->name('guru.confirm');
    Route::get('/input-absen/{jam}', [AbsensiController::class, 'create'])->name('guru.input-absen');
    Route::post('/simpan-absen', [AbsensiController::class, 'store'])->name('guru.simpan-absen');

    // 3. Rekap
    Route::get('/rekap-absen', [GuruRekap::class, 'index'])->name('guru.rekap');
});

// 5. Route Profile Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/admin/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::post('/admin/pengumuman/update/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/admin/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    Route::delete('/admin/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');
    Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    Route::delete('/admin/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
});

require __DIR__ . '/auth.php';

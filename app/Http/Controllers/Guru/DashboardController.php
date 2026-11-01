<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::where('status', 'aktif')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('kategori', 'agenda')
                        ->whereRaw('CURDATE() <= DATE_ADD(tgl_tampil, INTERVAL 1 DAY)');
                })->orWhere(function ($q) {
                    $q->where('kategori', '!=', 'agenda')
                        ->whereRaw('CURDATE() <= DATE_ADD(tgl_tampil, INTERVAL 14 DAY)');
                });
            })
            ->orderBy('id_pengumuman', 'desc')
            ->get();

        return view('guru.dashboard', compact('pengumuman'));
    }

    public function cekLibur()
    {
        $hariIni = Carbon::now();
        $hariSaja = $hariIni->dayOfWeek;
        $tanggalHariIni = $hariIni->toDateString();

        // 1. Cek Hari Minggu
        /*
        if ($hariSaja === Carbon::SUNDAY) {
            return response()->json([
                'is_libur' => true,
               'pesan' => 'Hari ini adalah hari Minggu. Penginputan absensi libur akhir pekan!'
            ]);
        }*/

        // 2. Cek Manual Input Admin di Tabel hari_libur
        $cekLiburManual = DB::table('hari_libur')->where('tanggal', $tanggalHariIni)->first();
        if ($cekLiburManual) {
            return response()->json([
                'is_libur' => true,
                'pesan' => 'Hari ini sekolah libur: ' . $cekLiburManual->keterangan
            ]);
        }

        // Jika hari masuk sekolah biasa
        return response()->json(['is_libur' => false]);
    }
}

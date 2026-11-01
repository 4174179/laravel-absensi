<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Auth::user()->kelas;
        $id_kelas_guru = $kelas ? $kelas->id_kelas : null;

        $list_tahun_ajaran = DB::table('tahun_ajaran')->orderBy('id_tahun_ajaran', 'desc')->get();
        $siswa = []; 

        if ($request->filled('id_tahun_ajaran')) {
            $id_tahun_ajaran = $request->id_tahun_ajaran;
            $filter_sesi = $request->filter_sesi;

            $query = DB::table('siswa as s')
                ->leftJoin('absensi as a', function ($join) use ($id_tahun_ajaran, $filter_sesi) {
                    $join->on('s.id_siswa', '=', 'a.id_siswa')
                        ->where('a.id_tahun_ajaran', $id_tahun_ajaran);

                    if ($filter_sesi && $filter_sesi !== 'all') {
                        $join->where('a.sesi', $filter_sesi);
                    }
                })
                ->selectRaw("
                    s.id_siswa, 
                    s.nama_siswa, 
                    s.nis as nisn,
                    SUM(CASE WHEN a.status = 'H' THEN 1 ELSE 0 END) AS hadir,
                    SUM(CASE WHEN a.status = 'S' THEN 1 ELSE 0 END) AS sakit,
                    SUM(CASE WHEN a.status = 'I' THEN 1 ELSE 0 END) AS izin,
                    SUM(CASE WHEN a.status = 'A' THEN 1 ELSE 0 END) AS alpa,
                    COUNT(a.status) AS total_input
                ")
                ->where('s.id_kelas', $id_kelas_guru) 
                ->groupBy('s.id_siswa', 's.nama_siswa', 's.nis')
                ->orderBy('s.nama_siswa', 'asc');

            $siswa = $query->get();
        }

        return view('guru.rekap_absen', [
            'siswa' => $siswa, 
            'list_tahun_ajaran' => $list_tahun_ajaran,
            'title' => "Rekap Absensi " . ($kelas->nama_kelas ?? '')
        ]);
    }
}
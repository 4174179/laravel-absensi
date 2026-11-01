<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\TahunAjaran; // Pastikan memanggil model TahunAjaran milikmu
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $id_kelas = $request->input('id_kelas');
        $tahun_terpilih = $request->input('id_tahun_ajaran');

        // Mengambil daftar untuk isi dropdown filter
        $list_tahun = DB::table('tahun_ajaran')->orderBy('tahun', 'DESC')->get();
        $list_kelas = Kelas::orderBy('nama_kelas', 'ASC')->get();

        $list_rekap = [];
        $mode_semua = false;

        // KONDISI UTAMA: Query HANYA berjalan jika user sudah menekan tombol Tampilkan (parameter tahun terisi)
        if (!empty($tahun_terpilih)) {
            if (empty($id_kelas)) {
                $mode_semua = true;
                $list_rekap = DB::table('kelas as k')
                    ->leftJoin('siswa as s', 'k.id_kelas', '=', 's.id_kelas')
                    ->leftJoin('absensi as a', function ($join) use ($tahun_terpilih) {
                        $join->on('s.id_siswa', '=', 'a.id_siswa')
                            ->where('s.id_tahun_ajaran', $tahun_terpilih);
                    })
                    ->select(
                        'k.nama_kelas',
                        DB::raw("SUM(CASE WHEN a.status = 'H' THEN 1 ELSE 0 END) AS hadir"),
                        DB::raw("SUM(CASE WHEN a.status = 'S' THEN 1 ELSE 0 END) AS sakit"),
                        DB::raw("SUM(CASE WHEN a.status = 'I' THEN 1 ELSE 0 END) AS izin"),
                        DB::raw("SUM(CASE WHEN a.status = 'A' THEN 1 ELSE 0 END) AS alpa"),
                        DB::raw("COUNT(a.id_absensi) AS total")
                    )
                    ->groupBy('k.id_kelas', 'k.nama_kelas')
                    ->orderBy('k.nama_kelas', 'ASC')
                    ->get();
            } else {
                $mode_semua = false;
                $list_rekap = DB::table('siswa as s')
                    ->leftJoin('absensi as a', function ($join) use ($tahun_terpilih) {
                        $join->on('s.id_siswa', '=', 'a.id_siswa')
                            ->where('s.id_tahun_ajaran', $tahun_terpilih);
                    })
                    ->where('s.id_kelas', $id_kelas)
                    ->where('s.id_tahun_ajaran', $tahun_terpilih)
                    ->select(
                        's.nis',
                        's.nama_siswa',
                        DB::raw("SUM(CASE WHEN a.status = 'H' THEN 1 ELSE 0 END) AS hadir"),
                        DB::raw("SUM(CASE WHEN a.status = 'S' THEN 1 ELSE 0 END) AS sakit"),
                        DB::raw("SUM(CASE WHEN a.status = 'I' THEN 1 ELSE 0 END) AS izin"),
                        DB::raw("SUM(CASE WHEN a.status = 'A' THEN 1 ELSE 0 END) AS alpa"),
                        DB::raw("COUNT(a.id_absensi) AS total")
                    )
                    ->groupBy('s.id_siswa', 's.nis', 's.nama_siswa')
                    ->orderBy('s.nama_siswa', 'ASC')
                    ->get();
            }
        }

        return view('admin.rekap_admin', compact('list_rekap', 'list_kelas', 'list_tahun', 'tahun_terpilih', 'mode_semua', 'id_kelas'));
    }
}

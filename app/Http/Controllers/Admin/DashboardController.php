<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. Logika Sapaan & Icon ---
        $hour = date('H');
        if ($hour >= 5 && $hour < 11) {
            $sapaan = "Selamat Pagi";
            $icon = "fa-sun text-warning";
        } elseif ($hour >= 11 && $hour < 15) {
            $sapaan = "Selamat Siang";
            $icon = "fa-cloud-sun text-info";
        } elseif ($hour >= 15 && $hour < 18) {
            $sapaan = "Selamat Sore";
            $icon = "fa-cloud-meatball text-secondary";
        } else {
            $sapaan = "Selamat Malam";
            $icon = "fa-moon text-primary";
        }

        // --- 2. Statistik & Chart Besar (Hari Ini Per Kelas) ---
        $stats = [
            'total_guru' => User::where('role', 'guru')->count(),
            'total_siswa' => Siswa::where('status', 'aktif')->count(),
            'total_kelas' => Kelas::count(),
        ];

        $tgl_hari_ini = now()->toDateString();

        $max_siswa = Siswa::where('status', 'aktif')
            ->selectRaw('count(*) as total')
            ->groupBy('id_kelas')
            ->orderBy('total', 'DESC')
            ->value('total') ?? 30;

        $subQueryStatusSiswa = DB::table('absensi')
            ->select('id_siswa')
            ->where('tgl_absen', $tgl_hari_ini)
            ->groupBy('id_siswa')
            ->selectRaw("
                CASE 
                    WHEN SUM(CASE WHEN status = 'A' THEN 1 ELSE 0 END) > 0 THEN 'A'
                    WHEN SUM(CASE WHEN status = 'I' THEN 1 ELSE 0 END) > 0 THEN 'I'
                    WHEN SUM(CASE WHEN status = 'S' THEN 1 ELSE 0 END) > 0 THEN 'S'
                    ELSE 'H'
                END as status_final
            ");

        $data_status_kelas = Kelas::select('id_kelas', 'nama_kelas')
            ->get()
            ->map(function ($kelas) use ($subQueryStatusSiswa) {
                $rekap = DB::table('siswa')
                    ->joinSub($subQueryStatusSiswa, 'status_harian', function ($join) {
                        $join->on('siswa.id_siswa', '=', 'status_harian.id_siswa');
                    })
                    ->where('siswa.id_kelas', $kelas->id_kelas)
                    ->selectRaw("
                        SUM(CASE WHEN status_final = 'H' THEN 1 ELSE 0 END) as h,
                        SUM(CASE WHEN status_final = 'S' THEN 1 ELSE 0 END) as s,
                        SUM(CASE WHEN status_final = 'I' THEN 1 ELSE 0 END) as i,
                        SUM(CASE WHEN status_final = 'A' THEN 1 ELSE 0 END) as a
                    ")
                    ->first();

                return [
                    'nama_kelas' => $kelas->nama_kelas,
                    'h' => (int) ($rekap->h ?? 0),
                    's' => (int) ($rekap->s ?? 0),
                    'i' => (int) ($rekap->i ?? 0),
                    'a' => (int) ($rekap->a ?? 0),
                ];
            });

        // --- 3. Logic Chart Kecil (Tren 7 Hari Terakhir) ---
        $labels_kecil = [];
        $data_h = [];
        $data_s = [];
        $data_i = [];
        $data_a = [];

        for ($i = 6; $i >= 0; $i--) {
            $tgl_carbon = now()->subDays($i);
            $labels_kecil[] = $tgl_carbon->translatedFormat('d M');
            $tgl_db = $tgl_carbon->toDateString();

            $subQuery7Hari = DB::table('absensi')
                ->select('id_siswa')
                ->where('tgl_absen', $tgl_db)
                ->groupBy('id_siswa')
                ->selectRaw("
                    CASE 
                        WHEN SUM(CASE WHEN status = 'A' THEN 1 ELSE 0 END) > 0 THEN 'A'
                        WHEN SUM(CASE WHEN status = 'I' THEN 1 ELSE 0 END) > 0 THEN 'I'
                        WHEN SUM(CASE WHEN status = 'S' THEN 1 ELSE 0 END) > 0 THEN 'S'
                        ELSE 'H'
                    END as status_final
                ");

            $res = DB::table(DB::raw("({$subQuery7Hari->toSql()}) as daily_status"))
                ->mergeBindings($subQuery7Hari)
                ->selectRaw("
                    SUM(CASE WHEN status_final = 'H' THEN 1 ELSE 0 END) as h,
                    SUM(CASE WHEN status_final = 'S' THEN 1 ELSE 0 END) as s,
                    SUM(CASE WHEN status_final = 'I' THEN 1 ELSE 0 END) as i,
                    SUM(CASE WHEN status_final = 'A' THEN 1 ELSE 0 END) as a
                ")->first();

            $data_h[] = (int) ($res->h ?? 0);
            $data_s[] = (int) ($res->s ?? 0);
            $data_i[] = (int) ($res->i ?? 0);
            $data_a[] = (int) ($res->a ?? 0);
        }

        // --- 4. Pengumuman ---
        $pengumuman = DB::table('tb_pengumuman')
            ->where('tgl_tampil', '>=', now()->subDays(14))
            ->orderBy('tgl_tampil', 'desc')
            ->get();

        return view('admin.dashboard', [
            'sapaan' => $sapaan,
            'icon' => $icon,
            'total_guru'  => $stats['total_guru'],
            'total_siswa' => $stats['total_siswa'],
            'total_kelas' => $stats['total_kelas'],
            'pengumuman'  => $pengumuman,

            'labels_besar' => json_encode(collect($data_status_kelas)->pluck('nama_kelas')),
            'h_besar'      => json_encode(collect($data_status_kelas)->pluck('h')),
            's_besar'      => json_encode(collect($data_status_kelas)->pluck('s')),
            'i_besar'      => json_encode(collect($data_status_kelas)->pluck('i')),
            'a_besar'      => json_encode(collect($data_status_kelas)->pluck('a')),
            'max_siswa'   => $max_siswa,

            'labels_kecil' => json_encode($labels_kecil),
            'h_kecil'      => json_encode($data_h),
            's_kecil'      => json_encode($data_s),
            'i_kecil'      => json_encode($data_i),
            'a_kecil'      => json_encode($data_a),
        ]);
    }
}

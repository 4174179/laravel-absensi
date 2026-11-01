<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\SesiAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $id_user = Auth::id();
        $tgl_sekarang = date('Y-m-d');
        $jam_sekarang = date('H:i:s'); // Jam real-time server

        // Ambil ID Sesi yang sudah diisi hari ini
        $sesi_selesai = Absensi::where('id_user', $id_user)
            ->where('tgl_absen', $tgl_sekarang)
            ->distinct()
            ->pluck('sesi')
            ->toArray();

        // Ambil semua sesi aktif
        $all_sesi = SesiAbsensi::where('is_active', 1)->orderBy('id_sesi', 'asc')->get();

        // Filter: Hanya tampilkan sesi yang sudah WAKTUNYA TIBA (jam_sekarang >= jam_buka) ATAU sudah pernah diisi
        $list_sesi = $all_sesi->filter(function ($sesi) use ($jam_sekarang, $sesi_selesai) {
            $is_waktunya_tiba = ($jam_sekarang >= $sesi->jam_buka);
            $is_already_done = in_array($sesi->id_sesi, $sesi_selesai);

            return $is_waktunya_tiba || $is_already_done;
        });

        return view('guru.confirm_session', compact('list_sesi', 'sesi_selesai', 'jam_sekarang'));
    }

    public function create(Request $request, $jam)
    {
        $user = Auth::user();
        $tgl_sekarang = date('Y-m-d');
        $jam_sekarang = date('H:i:s');

        $sesi = SesiAbsensi::find($jam);

        if (!$sesi || !$sesi->is_active) {
            return redirect()->route('guru.dashboard')->with('error', 'Sesi absensi tidak ditemukan atau nonaktif!');
        }

        if ($jam_sekarang < $sesi->jam_buka) {
            return redirect()->route('guru.dashboard')->with('error', "Gagal! {$sesi->nama_sesi} belum dibuka. Sesi baru dibuka pukul {$sesi->jam_buka} WIB.");
        }

        // Tentukan status sesi dari request URL, jika kosong cek jam real-time
        $status_sesi = $request->query('status_sesi', ($jam_sekarang > $sesi->jam_tutup ? 'Telat' : 'Tepat Waktu'));

        $siswa = Siswa::where('id_kelas', $user->kelas->id_kelas)
            ->with([
                'absensi' => function ($q) use ($tgl_sekarang, $jam) {
                    $q->where('tgl_absen', $tgl_sekarang)->where('sesi', $jam);
                }
            ])
            ->orderBy('nama_siswa', 'asc')
            ->get();

        return view('guru.input_absen', compact('siswa', 'jam', 'sesi', 'status_sesi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|array',
            'status' => 'required|array',
            'jam_pelajaran' => 'required',
        ]);

        $tahun_aktif = TahunAjaran::where('is_aktif', 1)->first();

        if (!$tahun_aktif) {
            return back()->with('error', 'Gagal simpan: Belum ada Tahun Ajaran yang berstatus AKTIF!');
        }

        try {
            if (empty($request->id_siswa)) {
                return back()->with('error', 'Gagal simpan: Tidak ada data siswa yang dikirim!');
            }

            DB::transaction(function () use ($request, $tahun_aktif) {
                foreach ($request->id_siswa as $key => $id_siswa) {
                    $siswa = Siswa::find($id_siswa);
                    $id_kelas = $siswa ? $siswa->id_kelas : null;

                    Absensi::updateOrCreate(
                        [
                            'id_siswa' => $id_siswa,
                            'tgl_absen' => date('Y-m-d'),
                            'sesi' => $request->jam_pelajaran,
                        ],
                        [
                            'id_kelas' => $id_kelas,
                            'id_tahun_ajaran' => $tahun_aktif->id_tahun_ajaran,
                            'id_user' => Auth::id(),
                            'status' => $request->status[$key],
                            'status_sesi' => $request->status_sesi ?? 'Tepat Waktu', // <-- DISIMPANKAN KE DB
                            'keterangan' => $request->keterangan[$key] ?? null,
                        ]
                    );
                }
            });

            return redirect()->route('guru.dashboard')->with('success', 'Absensi Berhasil Disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal Simpan: ' . $e->getMessage());
        }
    }
}

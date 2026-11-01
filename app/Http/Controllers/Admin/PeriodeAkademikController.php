<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PeriodeAkademikController extends Controller
{
    public function index(Request $request)
    {
        $list_kelas = Kelas::orderBy('nama_kelas', 'ASC')->get();
        $list_tahun = TahunAjaran::orderBy('tahun', 'DESC')->get();
        $tahunAktif = TahunAjaran::where('is_aktif', true)->orderBy('id_tahun_ajaran', 'DESC')->first();

        $semua_siswa = Siswa::with('kelas')
            ->where('status', 'aktif')
            ->orderBy('id_kelas', 'ASC')
            ->orderBy('nama_siswa', 'ASC')
            ->get();

        $tingkatTertinggi = 0;
        foreach ($list_kelas as $k) {
            preg_match('/\d+/', $k->nama_kelas, $matches);
            $tingkat = isset($matches[0]) ? (int)$matches[0] : 0;
            if ($tingkat > $tingkatTertinggi) {
                $tingkatTertinggi = $tingkat;
            }
        }

        $list_siswa = [];
        foreach ($semua_siswa as $siswa) {
            $nama_kelas_sekarang = $siswa->kelas->nama_kelas ?? '';
            preg_match('/\d+/', $nama_kelas_sekarang, $matches);
            $tingkat_sekarang = isset($matches[0]) ? (int)$matches[0] : null;

            $opsi_kelas = [];
            $is_tingkat_akhir = false;

            if ($tingkat_sekarang) {
                if ($tingkat_sekarang >= $tingkatTertinggi) {
                    $is_tingkat_akhir = true;
                } else {
                    $tingkat_target = $tingkat_sekarang + 1;
                    foreach ($list_kelas as $k) {
                        preg_match('/\d+/', $k->nama_kelas, $target_matches);
                        $tingkat_k = isset($target_matches[0]) ? (int)$target_matches[0] : 0;
                        if ($tingkat_k === $tingkat_target) {
                            $opsi_kelas[] = $k;
                        }
                    }
                }
            } else {
                $opsi_kelas = $list_kelas;
            }

            $siswa->opsi_kelas_smart = $opsi_kelas;
            $siswa->is_tingkat_akhir = $is_tingkat_akhir;
            $list_siswa[] = $siswa;
        }

        return view('admin.periode_akademik', compact('list_kelas', 'list_tahun', 'list_siswa', 'tahunAktif'));
    }

    public function gantiPeriode(Request $request)
    {
        $request->validate([
            'target_tahun' => 'required|exists:tahun_ajaran,id_tahun_ajaran',
            'siswa_pilih' => 'required|array',
        ]);

        $id_tahun_baru = $request->target_tahun;
        $siswa_pilih = $request->input('siswa_pilih', []);
        $kelas_baru_array = $request->input('kelas_baru', []);

        DB::beginTransaction();

        try {
            //dd($request->all());
            $tahunAktif = TahunAjaran::where('is_aktif', true)->orderBy('id_tahun_ajaran', 'DESC')->first();
            if (!$tahunAktif) {
                return redirect()->back()->with('error', 'Gagal memuat tahun aktif saat ini.');
            }

            $semuaSiswaAktif = Siswa::where('status', 'aktif')
                ->whereIn('id_siswa', $siswa_pilih)
                ->get();

            foreach ($semuaSiswaAktif as $siswa) {
                DB::table('riwayat_akademik')->insert([
                    'id_siswa' => $siswa->id_siswa,
                    'nis' => $siswa->nis,
                    'nama_siswa' => $siswa->nama_siswa,
                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    'id_kelas' => $siswa->id_kelas,
                    'id_tahun_ajaran' => $tahunAktif->id_tahun_ajaran,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            foreach ($semuaSiswaAktif as $siswa) {
                $target = $kelas_baru_array[$siswa->id_siswa] ?? '';

                if ($target === 'lulus') {
                    DB::table('siswa')->where('id_siswa', $siswa->id_siswa)->update([
                        'status' => 'lulus',
                        'id_kelas' => null,
                        'id_tahun_ajaran' => $id_tahun_baru
                    ]);
                } elseif ($target === 'tinggal' || empty($target)) {
                    DB::table('siswa')->where('id_siswa', $siswa->id_siswa)->update([
                        'id_tahun_ajaran' => $id_tahun_baru
                    ]);
                } else {
                    DB::table('siswa')->where('id_siswa', $siswa->id_siswa)->update([
                        'id_kelas' => $target,
                        'id_tahun_ajaran' => $id_tahun_baru
                    ]);
                }
            }

            DB::table('tahun_ajaran')->update(['is_aktif' => false]);
            DB::table('tahun_ajaran')->where('id_tahun_ajaran', $id_tahun_baru)->update(['is_aktif' => true]);

            DB::commit();
            return redirect()->route('admin.periode.index')->with('success', 'Periode akademik berhasil diubah!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Ganti Periode Gagal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function storeTahun(Request $request)
    {
        $request->validate([
            'tahun' => [
                'required',
                'string',
                'max:9',
                'unique:tahun_ajaran,tahun',
                'regex:/^\d{4}\/\d{4}$/'
            ],
        ], [
            // Kostumisasi pesan error jika validasi gagal
            'tahun.max' => 'Format tahun ajaran tidak boleh lebih dari 9 karakter!',
            'tahun.regex' => 'Format yang dimasukkan salah! Wajib menggunakan format tahun yang benar (Contoh: 2025/2026).',
            'tahun.unique' => 'Periode tahun ajaran tersebut sudah terdaftar di sistem.'
        ]);

        TahunAjaran::create([
            'tahun' => $request->tahun,
            'is_aktif' => false
        ]);

        return redirect()->back()->with('success', 'Periode baru berhasil ditambahkan.');
    }

    public function aktifkanTahun($id)
    {
        DB::beginTransaction();
        try {
            DB::table('tahun_ajaran')->update(['is_aktif' => false]);

            $tahun = TahunAjaran::findOrFail($id);
            $tahun->update(['is_aktif' => true]);

            DB::commit();
            return redirect()->back()->with('success', 'Periode berhasil diaktifkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengaktifkan periode.');
        }
    }
}

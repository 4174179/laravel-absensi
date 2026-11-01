<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran; 

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $tahunAktif = DB::table('tahun_ajaran')->where('is_aktif', 1)->first();
        $tahun_terpilih = $request->get('id_tahun_ajaran', $tahunAktif ? $tahunAktif->id_tahun_ajaran : null);
        $is_tahun_aktif = ($tahun_terpilih == ($tahunAktif ? $tahunAktif->id_tahun_ajaran : null));

        $list_tahun = DB::table('tahun_ajaran')->orderBy('tahun', 'DESC')->get();

        if ($is_tahun_aktif) {
            $list_siswa = Siswa::with('kelas')
                ->where('id_tahun_ajaran', $tahun_terpilih)
                ->where('status', 'aktif')
                ->orderBy('id_kelas', 'ASC')
                ->orderBy('nama_siswa', 'ASC')
                ->orderBy('nis', 'ASC')
                ->get();
        } else {
            $list_siswa = DB::table('riwayat_akademik')
                ->leftJoin('kelas', 'riwayat_akademik.id_kelas', '=', 'kelas.id_kelas')
                ->where('riwayat_akademik.id_tahun_ajaran', $tahun_terpilih)
                ->select('riwayat_akademik.*', 'kelas.nama_kelas')
                ->orderBy('kelas.id_kelas', 'ASC')
                ->orderBy('riwayat_akademik.nama_siswa', 'ASC')
                ->orderBy('riwayat_akademik.nis', 'ASC')
                ->get();
        }

        $title = "Manajemen Data Siswa";
        return view('admin.siswa_manage', compact('list_siswa', 'list_tahun', 'tahun_terpilih', 'is_tahun_aktif', 'title'));
    }

    public function create()
    {
        $list_kelas = Kelas::orderBy('nama_kelas', 'ASC')->get();
        return view('admin.form.siswa.siswa_add', compact('list_kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'id_kelas' => 'required'
        ]);

        $tahun_aktif = TahunAjaran::where('is_aktif', true)->first();
        if (!$tahun_aktif) {
            return redirect()->back()->with('error', 'Aktifkan tahun ajaran terlebih dahulu!');
        }

        Siswa::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'jenis_kelamin' => $request->jenis_kelamin,
            'id_kelas' => $request->id_kelas,
            'status' => 'aktif',
            'id_tahun_ajaran' => $tahun_aktif->id_tahun_ajaran
        ]);

        return redirect()->route('siswa_manage')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $list_kelas = Kelas::with('waliKelas')->orderBy('nama_kelas', 'ASC')->get();

        return view('admin.form.siswa.siswa_edit', compact('siswa', 'list_kelas'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $id . ',id_siswa',
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'id_kelas' => 'required'
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa_manage')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $deleted = DB::table('siswa')
            ->where('id_siswa', $id)
            ->delete();

        if ($deleted) {
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Data siswa berhasil dihapus!'
                ], 200);
            }
            return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
        }

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menghapus data siswa.'
            ], 422);
        }

        return redirect()->back()->with('error', 'Gagal menghapus data siswa.');
    }
}
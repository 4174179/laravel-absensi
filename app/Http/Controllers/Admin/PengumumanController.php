<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = DB::table('tb_pengumuman')->orderBy('tgl_tampil', 'desc')->get();
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function store(Request $request)
    {
        Pengumuman::create($request->all());
        return response()->json(['status' => 'success', 'message' => 'Pengumuman berhasil dibuat!'], 200);
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::where('id_pengumuman', $id)->first();

        if (!$pengumuman) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        $pengumuman->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'isi' => $request->isi,
            'tgl_tampil' => $request->tgl_tampil,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data diperbarui!'], 200);
    }

    public function destroy(Request $request, $id)
    {
        DB::table('tb_pengumuman')->where('id_pengumuman', $id)->delete();

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Pengumuman berhasil dihapus!'
            ], 200);
        }

        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}
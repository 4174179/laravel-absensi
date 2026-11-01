<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HariLibur;

class HariLiburController extends Controller
{
    public function index()
    {
        $hari_libur = HariLibur::orderBy('tanggal', 'desc')->get();
        return view('admin.hari_libur', compact('hari_libur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ]);

        $liburBaru = HariLibur::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data hari libur berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $hari_libur = HariLibur::find($id);

        if (!$hari_libur) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($hari_libur, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ]);

        $hari_libur = HariLibur::find($id);

        if (!$hari_libur) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $hari_libur->update([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data hari libur berhasil diperbarui!',
                'data' => [
                    'id' => $id,
                    'tanggal' => $request->tanggal,
                    'keterangan' => $request->keterangan
                ]
            ], 200);
        }
    }

    public function destroy(Request $request, $id)
    {
        $hari_libur = HariLibur::find($id);

        if (!$hari_libur) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $hari_libur->delete();

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Data hari libur berhasil dihapus.'
            ], 200);
        }

        return redirect()->route('admin.libur.index')->with('sukses', 'Data hari libur berhasil dihapus.');
    }
}

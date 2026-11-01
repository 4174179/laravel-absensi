<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiAbsensi;
use Carbon\Carbon;

class SesiAbsensiController extends Controller
{
    public function index()
    {
        $list_sesi = SesiAbsensi::orderBy('id_sesi', 'ASC')->get();
        return view('admin.sesi_manage', compact('list_sesi'));
    }

    public function store()
    {
        try {
            $totalSesi = SesiAbsensi::count() + 1;

            // Ambil sesi yang memiliki jam_tutup paling akhir (paling malam)
            $lastSesi = SesiAbsensi::orderBy('jam_tutup', 'desc')->first();

            if ($lastSesi) {
                // Jam buka sesi baru SAMA DENGAN jam tutup sesi terakhir
                $jamBukaBaru = Carbon::parse($lastSesi->jam_tutup)->addHour()->format('H:i');

                // Jam tutup sesi baru = Jam buka baru + 1 jam
                $jamTutupBaru = Carbon::parse($jamBukaBaru)->addHour()->format('H:i');
            } else {
                // Default jika database masih kosong
                $jamBukaBaru = '07:00';
                $jamTutupBaru = '08:00';
            }

            SesiAbsensi::create([
                'nama_sesi' => 'Sesi ' . $totalSesi,
                'jam_buka'  => $jamBukaBaru,
                'jam_tutup' => $jamTutupBaru,
                'is_active' => 1,
            ]);

            return redirect()->route('admin_sesi', ['status' => 'sukses']);
        } catch (\Exception $e) {
            return redirect()->route('admin_sesi', ['status' => 'gagal']);
        }
    }

    public function update(Request $request, $id)
    {
        $sesi = SesiAbsensi::findOrFail($id);

        // 1. Validasi Format Dasar
        $request->validate([
            'nama_sesi' => 'required|string|max:100',
            'jam_buka'  => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka',
            'is_active' => 'required|in:0,1',
        ], [
            'jam_tutup.after' => 'Jam tutup harus lebih besar dari jam buka!'
        ]);

        try {
            // 2. FAIL-SAFE A: Cek Nama Sesi Kembar (Kecuali Sesi Ini Sendiri)
            $namaExists = SesiAbsensi::where('id_sesi', '!=', $id)
                ->where('nama_sesi', $request->nama_sesi)
                ->exists();

            if ($namaExists) {
                return redirect()->route('admin_sesi', ['status' => 'gagal_sesi'])
                    ->with('error', 'Gagal! Nama sesi sudah digunakan.');
            }

            // 3. FAIL-SAFE B: Cek Jam Bentrok dengan Sesi Lain (Hanya Cek Sesi yang Aktif)
            if ($request->is_active == 1) {
                $jamBentrok = SesiAbsensi::where('id_sesi', '!=', $id)
                    ->where('is_active', 1)
                    ->where(function ($query) use ($request) {
                        $query->whereBetween('jam_buka', [$request->jam_buka, $request->jam_tutup])
                            ->orWhereBetween('jam_tutup', [$request->jam_buka, $request->jam_tutup])
                            ->orWhere(function ($q) use ($request) {
                                $q->where('jam_buka', '<=', $request->jam_buka)
                                    ->where('jam_tutup', '>=', $request->jam_tutup);
                            });
                    })
                    ->exists();

                if ($jamBentrok) {
                    return redirect()->route('admin_sesi', ['status' => 'gagal_sesi'])
                        ->with('error', 'Gagal! Jam operasional bentrok dengan sesi aktif lainnya.');
                }
            }

            // 4. Jika Semua Lolos Fail-Safe -> Simpan Data
            $sesi->update([
                'nama_sesi' => $request->nama_sesi,
                'jam_buka'  => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'is_active' => $request->is_active,
            ]);

            return redirect()->route('admin_sesi', ['status' => 'update_sukses']);
        } catch (\Exception $e) {
            return redirect()->route('admin_sesi', ['status' => 'gagal']);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $sesi = SesiAbsensi::findOrFail($id);
            $sesi->delete();

            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Sesi absensi berhasil dihapus!'
                ], 200);
            }

            return redirect()->route('admin_sesi', ['status' => 'hapus_sukses']);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Gagal menghapus sesi absensi.'
                ], 422);
            }

            return redirect()->route('admin_sesi', ['status' => 'gagal']);
        }
    }
}

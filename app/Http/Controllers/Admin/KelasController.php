<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;

class KelasController extends Controller
{
    public function index()
    {
        $list_kelas = Kelas::with('waliKelas')
            ->orderBy('nama_kelas', 'ASC')
            ->get();

        return view('admin.kelas_manage', compact('list_kelas'));
    }

    public function create()
    {
        $list_guru = User::where('role', 'guru')
            ->with('kelas')
            ->orderBy('nama_lengkap', 'ASC')
            ->get();

        return view('admin.form.kelas.kelas_add', compact('list_guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'tingkat'    => 'required|integer|between:1,6',
            'id_user'    => 'required|exists:users,id_user',
            'kode_kelas' => 'required|string|unique:kelas,kode_pin'
        ]);

        $walasAda = Kelas::where('id_user', $request->id_user)->first();
        if ($walasAda) {
            return response()->json([
                'message' => 'Gagal! Guru ini sudah menjadi Wali Kelas di ' . $walasAda->nama_kelas
            ], 422);
        }

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat'    => $request->tingkat,
            'id_user'    => $request->id_user,
            'kode_pin'   => $request->kode_kelas
        ]);

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Kelas baru berhasil dibuat!'], 200);
        }

        return redirect()->route('kelas_manage')->with('sukses', 'Kelas baru berhasil dibuat!');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);

        $list_guru = User::where('role', 'guru')
            ->with('kelas')
            ->orderBy('nama_lengkap', 'ASC')
            ->get();

        return view('admin.form.kelas.kelas_edit', compact('kelas', 'list_guru'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required',
            'tingkat'    => 'required|integer|between:1,6',
            'id_user'    => 'required|exists:users,id_user',
            'kode_kelas' => 'required|string|unique:kelas,kode_pin,' . $kelas->id_kelas . ',id_kelas'
        ]);

        $walasAda = Kelas::where('id_user', $request->id_user)
            ->where('id_kelas', '!=', $id)
            ->first();

        if ($walasAda) {
            return response()->json([
                'message' => 'Gagal! Guru ini sudah menjadi Wali Kelas di ' . $walasAda->nama_kelas
            ], 422);
        }

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'tingkat'    => $request->tingkat,
            'id_user'    => $request->id_user,
            'kode_pin'   => $request->kode_kelas
        ]);

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Data kelas berhasil diubah!'], 200);
        }

        return redirect()->route('kelas_manage')->with('sukses', 'Data kelas berhasil diubah!');
    }

    public function destroy(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Kelas berhasil dihapus dari sistem!'
            ], 200);
        }

        return redirect()->route('kelas_manage')->with('sukses', 'Kelas berhasil dihapus dari sistem!');
    }

    public function checkOrDownloadQr($id)
    {
        $kelas = Kelas::findOrFail($id);

        if (empty($kelas->kode_pin)) {
            if (request()->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "Kode PIN / QR untuk kelas <b>{$kelas->nama_kelas}</b> belum di-setting!"
                ], 422);
            }
        }

        if (request()->ajax()) {
            return response()->json(['status' => 'success'], 200);
        }

        $pin = trim($kelas->kode_pin);

        // 1. Ambil gambar QR Code mentah dari QuickChart API
        $qrUrl = "https://quickchart.io/qr?text=" . urlencode($pin) . "&size=300";
        $qrBinary = @file_get_contents($qrUrl);

        if (!$qrBinary) {
            return back()->with('error', 'Gagal menghasilkan QR Code.');
        }

        // 2. Buat Canvas Gambar dengan GD Library PHP
        $qrImage = imagecreatefromstring($qrBinary);
        $width = imagesx($qrImage);
        $height = imagesy($qrImage);

        // Tambah ruang 50px di bagian bawah untuk teks PIN
        $extraHeight = 50;
        $canvas = imagecreatetruecolor($width, $height + $extraHeight);

        // Set warna background putih & teks hitam
        $white = imagecolorallocate($canvas, 255, 255, 255);
        $black = imagecolorallocate($canvas, 0, 0, 0);

        imagefill($canvas, 0, 0, $white);

        // Tempel QR Code ke Canvas
        imagecopy($canvas, $qrImage, 0, 0, 0, 0, $width, $height);

        // 3. Tulis Teks "PIN: [kode_pin]" di Bawah QR Code secara Centered
        $text = "PIN: " . $pin;
        $fontSize = 5; // Ukuran font bawaan GD (1 - 5)
        $fontWidth = imagefontwidth($fontSize);
        $textWidth = strlen($text) * $fontWidth;

        $x = ($width - $textWidth) / 2;
        $y = $height + 15;

        imagestring($canvas, $fontSize, (int)$x, (int)$y, $text, $black);

        // 4. Output Hasil Render Gambar ke Browser (Download Response)
        ob_start();
        imagepng($canvas);
        $imageData = ob_get_clean();

        // Bersihkan memori server
        imagedestroy($qrImage);
        imagedestroy($canvas);

        $cleanNamaKelas = str_replace(' ', '_', $kelas->nama_kelas);
        $fileName = "QR_Kelas_{$cleanNamaKelas}_{$pin}.png";

        return response($imageData, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}

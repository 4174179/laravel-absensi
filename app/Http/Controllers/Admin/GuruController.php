<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // Tampilan Tabel Daftar Guru (guru_manage)
    public function index()
    {
        $list_guru = User::where('role', 'guru')
            ->orderBy('nama_lengkap', 'ASC')
            ->get();

        return view('admin.guru_manage', compact('list_guru'));
    }

    // Proses Simpan Guru Baru (guru_add)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:5',
            'nama_lengkap' => 'required'
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'guru'
        ]);

        return redirect()->route('guru_manage')->with('sukses', 'Data Guru berhasil ditambahkan!');
    }

    // Proses Update Guru (guru_edit)
    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $guru->nama_lengkap = $request->nama_lengkap;
        $guru->username = $request->username;

        if ($request->filled('password_baru')) {
            $guru->password = Hash::make($request->password_baru);
        }

        $guru->save();

        return redirect()->route('guru_manage')->with('sukses', 'Data Guru berhasil diupdate!');
    }

    // Hapus Data Guru
    public function destroy($id)
    {
        $guru = User::findOrFail($id);
        $isWalas = Kelas::where('id_user', $id)->exists();

        if ($isWalas) {
            // Redirect balik sambil bawa status gagal
            return redirect()->to(url()->previous() . '?status=gagal_walas');
        }
        $guru->delete();

        return redirect()->route('guru_manage')->with('sukses', 'Data Guru berhasil dihapus!');
    }
}

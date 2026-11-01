@extends('layouts.admin')

@section('title', 'Kelola Sesi Absensi')

@section('content')
<header class="main-header">
    <div class="header-content">
        <h2><i class="fas fa-clock"></i> Kelola Sesi Absensi</h2>
    </div>
    <form action="{{ route('admin_sesi_store') }}" method="POST" style="margin: 0;">
        @csrf
        <button type="submit" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Sesi
        </button>
    </form>
</header>

<main class="main-content">
    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Nama Sesi</th>
                    <th style="width: 150px;" class="text-center">Jam Buka</th>
                    <th style="width: 150px;" class="text-center">Jam Tutup</th>
                    <th style="width: 130px;" class="text-center">Status</th>
                    <th style="width: 160px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($list_sesi as $index => $sesi)
                <tr>
                    <td class="text-center" style="vertical-align: middle;">{{ $index + 1 }}</td>

                    {{-- Form Edit Inline --}}
                    <form action="{{ route('admin_sesi_update', $sesi->id_sesi) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <td style="vertical-align: middle;">
                            <div class="form-group" style="margin: 0;">
                                <input type="text" name="nama_sesi" value="{{ old('nama_sesi', $sesi->nama_sesi) }}" required>
                            </div>
                        </td>

                        <td class="text-center" style="vertical-align: middle;">
                            <div class="form-group" style="margin: 0;">
                                <input type="time" name="jam_buka" value="{{ old('jam_buka', \Carbon\Carbon::parse($sesi->jam_buka)->format('H:i')) }}" required style="text-align: center;">
                            </div>
                        </td>

                        <td class="text-center" style="vertical-align: middle;">
                            <div class="form-group" style="margin: 0;">
                                <input type="time" name="jam_tutup" value="{{ old('jam_tutup', \Carbon\Carbon::parse($sesi->jam_tutup)->format('H:i')) }}" required style="text-align: center;">
                            </div>
                        </td>

                        <td class="text-center" style="vertical-align: middle;">
                            <div class="form-group" style="margin: 0;">
                                <select name="is_active">
                                    <option value="1" {{ $sesi->is_active == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ $sesi->is_active == 0 ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </td>

                        <td class="text-center" style="vertical-align: middle;">
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                {{-- Tombol Simpan (Update) --}}
                                <button type="submit" class="btn-save" style="padding: 6px 10px; font-size: 0.85rem;" title="Simpan Perubahan">
                                    <i class="fas fa-save"></i>
                                </button>
                    </form> {{-- End Form Update --}}

                    <a href="javascript:void(0)"
                        onclick="confirmDelete('{{ $sesi->id_sesi }}', '{{ $sesi->nama_sesi }}', 'sesi')"
                        class="btn-delete"
                        style="padding: 6px 10px; font-size: 0.85rem; border-radius: 6px; text-decoration: none;"
                        title="Hapus Sesi">
                        <i class="fas fa-trash"></i>
                    </a>
    </div>
    </td>
    </tr>
    @empty
    <tr id="no-data-row">
        <td colspan="6" class="text-center">
            <p>Belum ada data sesi absensi. Klik tombol <strong>+ Tambah Sesi</strong> untuk membuat baru.</p>
        </td>
    </tr>
    @endforelse
    </tbody>
    </table>
    </div>
</main>
@endsection
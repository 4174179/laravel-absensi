@extends('layouts.admin')

@section('title', 'Manajemen Hari Libur Sekolah')

@section('content')
    <header class="main-header">
        <h2><i class="fas fa-calendar-times"></i> Hari Libur Sekolah</h2>
    </header>

    <main class="main-content">
        <div class="dashboard-row">

            <div style="flex: 3; min-width: 300px;">
                <div class="card">
                    <div class="table-controls"
                        style="padding-bottom: 10px; border-bottom: 1px solid #eee; margin-bottom: 15px;">
                        <h3 style="font-size: 1.1rem; color: #2c3e50;"><i class="fas fa-calendar-plus"></i> Tambah Hari
                            Libur</h3>
                    </div>

                    <form id="form-tambah-libur" action="{{ route('admin.libur.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Tanggal Libur</label>
                            <input type="date" name="tanggal" id="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label>Keterangan / Nama Libur</label>
                            <input type="text" name="keterangan" id="keterangan"
                                placeholder="Misal: Libur HUT Kemerdekaan" required>
                        </div>
                        <button type="submit" class="btn-save" style="width: 100%;">
                            <i class="fas fa-save"></i> Simpan Hari Libur
                        </button>
                    </form>
                </div>
            </div>

            <div style="flex: 7; min-width: 450px;">
                <div class="card">
                    <div class="table-controls"
                        style="padding-bottom: 10px; border-bottom: 1px solid #eee; margin-bottom: 15px;">
                        <h3 style="font-size: 1.1rem; color: #2c3e50;"><i class="fas fa-calendar-alt"></i> Daftar Tanggal
                            Libur</h3>
                    </div>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th width="8%">No</th>
                                <th width="27%">Tanggal</th>
                                <th width="45%">Keterangan</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hari_libur as $index => $row)
                                <tr id="row-libur-{{ $row->id_libur }}">
                                    <td>{{ $index + 1 }}</td>

                                    <td class="kolom-tanggal" data-tanggal="{{ $row->tanggal }}">
                                        {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                                    </td>

                                    <td class="kolom-keterangan">{{ $row->keterangan }}</td>

                                    <td class="btn-action">
                                        <a href="javascript:void(0)" onclick="editHariLibur('{{ $row->id_libur }}')"
                                            class="btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)"
                                            onclick="confirmDelete('{{ $row->id_libur }}', 'Hari Libur ' + '{{ $row->keterangan }}', 'hari-libur')"
                                            class="btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center" style="color: #95a5a6; padding: 20px 0;">
                                        Belum ada data hari libur kustom.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <div class="modal-overlay hidden" id="modalEditLibur">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="font-size: 1.2rem; color: #2c3e50;"><i class="fas fa-edit"></i> Edit Hari Libur</h3>
            </div>
            <form id="form-edit-libur" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="edit_id">
                    <div class="form-group">
                        <label>Tanggal Libur</label>
                        <input type="date" id="edit_tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" id="edit_keterangan" name="keterangan" required>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn-reset" onclick="tutupModalLibur()" style="margin: 0;">Batal</button>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@extends('layouts.admin')

@section('title', 'Manajemen Data Kelas')

@section('content')
<header class="main-header">
    <h2><i class="fas fa-chalkboard"></i> {{ $title ?? 'Manajemen Data Kelas' }}</h2>
    <a href="{{ route('kelas.add') }}" class="btn-add"><i class="fas fa-plus-circle"></i> Tambah Kelas</a>
</header>

<main class="main-content">
    <div class="card">
        <div class="table-controls">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Cari..." class="input-search">
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Kode Kelas</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($list_kelas as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->nama_kelas }}</td>
                    <td>
                        @if ($row->waliKelas)
                        <i class="fas fa-user-tie"></i> {{ $row->waliKelas->nama_lengkap }}
                        @else
                        <span class="badge-warning">Belum Ditentukan</span>
                        @endif
                    </td>
                    <td>
                        @if(!empty($row->kode_pin))
                        <span class="badge-success">{{ $row->kode_pin }}</span>
                        @else
                        <span class="badge-danger">Kosong</span>
                        @endif
                    </td>
                    <td class="btn-action">
                        {{-- Tombol QR Poster --}}
                        <a href="javascript:void(0)"
                            class="btn-qr"
                            data-id="{{ $row->id_kelas }}"
                            data-url="{{ route('admin.kelas.download-qr', $row->id_kelas) }}"
                            onclick="handleQrClick(this)"
                            title="Cetak Poster QR & PIN">
                            <i class="fas fa-qrcode"></i>
                        </a>

                        {{-- Tombol Edit --}}
                        <a href="{{ route('kelas.edit', $row->id_kelas) }}" class="btn-edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Tombol Delete --}}
                        <a href="javascript:void(0)"
                            onclick="confirmDelete('{{ $row->id_kelas }}', '{{ $row->nama_kelas }}', 'kelas')"
                            class="btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Belum ada data kelas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
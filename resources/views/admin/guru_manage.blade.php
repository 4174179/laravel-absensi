@extends('layouts.admin')

@section('title', 'Manajemen Data Guru')

@section('content')
    <header class="main-header">
        <h2><i class="fas fa-user-tie"></i> Manajemen Data Guru</h2>
        <a href="{{ route('guru.add') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Guru
        </a>
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
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Tanggal Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list_guru as $index => $guru)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $guru->nama_lengkap }}</td>
                            <td>{{ $guru->username }}</td>
                            <td>
                            {{ $guru->created_at->translatedFormat('d M Y') }}</td>
                            <td class="btn-action">
                                <a href="{{ route('guru.edit', $guru->id_user) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)"
                                    onclick="confirmDelete('{{ $guru->id_user}}', '{{ $guru->nama_lengkap }}', 'guru')"
                                    class="btn-delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">Belum ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
@endsection
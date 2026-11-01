@extends('layouts.admin')

@section('title', 'Manajemen Data Siswa')

@section('content')
    <header class="main-header">
        <h2><i class="fas fa-users"></i> {{ $title ?? 'Manajemen Data Siswa' }}</h2>
        
        @if($is_tahun_aktif)
            <a href="{{ route('siswa.add') }}" class="btn-add"><i class="fas fa-user-plus"></i> Tambah Siswa</a>
        @endif
    </header>

    <main class="main-content">
        <div class="card">
            <div class="table-controls" style="display: flex; gap: 15px; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <div class="search-container" style="flex: 1; margin-bottom: 0;">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" placeholder="Cari..." class="input-search" style="width: 100%;">
                </div>

                <div class="filter-container" style="width: 350px;">
                    <select id="filterTahunAjaran" class="input-search" style="width: 100%; cursor: pointer;">
                        <option value="">-- Tahun Ajaran --</option>
                        @foreach ($list_tahun as $thn)
                            <option value="{{ $thn->id_tahun_ajaran }}" {{ $tahun_terpilih == $thn->id_tahun_ajaran ? 'selected' : '' }}>
                                Tahun Ajaran: {{ $thn->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Jenis kelamin</th>
                        <th>Kelas</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list_siswa as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><code style="color: #3498db; font-weight: bold;">{{ $row->nis }}</code></td>
                            <td>{{ $row->nama_siswa }}</td>
                            <td>
                                <span class="badge-{{ ($row->jenis_kelamin == 'L') ? 'blue' : 'pink' }}">
                                    {{ $row->jenis_kelamin }}
                                </span>
                            </td>
                            <td>
                                {{ $row->kelas->nama_kelas ?? ($row->nama_kelas ?? 'Tanpa Kelas') }}
                            </td>
                            <td class="btn-action">
                                @if($is_tahun_aktif)
                                    <a href="{{ route('siswa.edit', $row->id_siswa) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                        onclick="confirmDelete('{{ $row->id_siswa }}', '{{ $row->nama_siswa }}', 'siswa')"
                                        class="btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                @else
                                    <span class="badge" style="color: #64748b; font-size: 0.85rem;"><i class="fas fa-lock"></i> Terkunci</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;">Belum ada data siswa pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const filterTA = document.getElementById('filterTahunAjaran');
            if (filterTA) {
                filterTA.addEventListener('change', function() {
                    let idTahun = this.value;
                    window.location.href = window.location.pathname + "?id_tahun_ajaran=" + idTahun;
                });
            }
        });
    </script>
@endsection
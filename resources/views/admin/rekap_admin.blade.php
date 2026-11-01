@extends('layouts.admin')

@section('title', 'Rekap Absensi Siswa')

@section('content')
<header class="main-header">
    <h2><i class="fas fa-file-alt"></i> Rekap Absensi Siswa</h2>
</header>

<main class="main-content">
    <div class="card" style="margin-bottom: 20px;">
        <form action="{{ route('admin.rekap') }}" method="GET" class="filter-form" id="formFilterRekap">
            <div class="filter-group">
                <label>Pilih Kelas</label>
                <select name="id_kelas">
                    <option value="">-- Semua Kelas --</option>
                    @if(isset($list_kelas))
                    @foreach ($list_kelas as $k)
                    <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>

            <div class="filter-group" style="width: 300px;">
                <label>Tahun Ajaran</label>
                <select name="id_tahun_ajaran" id="filterTahunAjaranRekap">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($list_tahun as $thn)
                    <option value="{{ $thn->id_tahun_ajaran }}" {{ request('id_tahun_ajaran') == $thn->id_tahun_ajaran ? 'selected' : '' }}>
                        Tahun Ajaran: {{ $thn->tahun }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="action-buttons" style="display: flex; gap: 10px; align-self: flex-end;">
                <button type="submit" class="btn-action btn-primary" style="background-color: #3498db; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">
                    <i class="fas fa-search"></i> Tampilkan
                </button>

                <button type="button" onclick="exportExcel()" class="btn-action btn-excel">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="table-controls">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Cari data..." class="input-search">
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    @if($mode_semua)
                    <th>Nama Kelas</th>
                    @else
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    @endif
                    <th>Hadir</th>
                    <th>Sakit</th>
                    <th>Izin</th>
                    <th>Alpa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($list_rekap as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @if($mode_semua)
                    <td>{{ $row->nama_kelas }}</td>
                    @else
                    <td>{{ $row->nis }}</td>
                    <td>{{ $row->nama_siswa }}</td>
                    @endif
                    <td>{{ $row->hadir }}</td>
                    <td>{{ $row->sakit }}</td>
                    <td>{{ $row->izin }}</td>
                    <td>{{ $row->alpa }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Silahkan pilih filter tanggal dan kelas lalu klik "Tampilkan".</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
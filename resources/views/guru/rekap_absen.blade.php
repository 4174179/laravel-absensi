@extends('layouts.guru')

@section('title', 'Rekap Absensi')

@section('content')
<div class="main-content">
    <div class="user-header-card mb-4">
        <h4 class="mb-0">
            <i class="fas fa-file-invoice mr-2"></i> Rekap Absensi {{ Auth::user()->kelas->nama_kelas }}
        </h4>
    </div>

    <div class="announcement-card border-secondary shadow mb-4">
        <div class="card-body">
            <form action="{{ route('guru.rekap') }}" method="GET" class="row align-items-end">
                <div class="col-md-3">
                    <label>Tahun Ajaran</label>
                    <select name="id_tahun_ajaran" id="filterTahunAjaranRekap" class="form-control select-nesaka">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach ($list_tahun_ajaran as $thn)
                        <option value="{{ $thn->id_tahun_ajaran }}" {{ request('id_tahun_ajaran') == $thn->id_tahun_ajaran ? 'selected' : '' }}>
                            Tahun Ajaran: {{ $thn->tahun }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold">Pilih Sesi</label>
                    <select name="filter_sesi" class="form-control select-nesaka">
                        <option value="all">Semua Sesi</option>
                        @foreach(range(1, 3) as $i)
                        <option value="{{ $i }}" {{ request('filter_sesi') == $i ? 'selected' : '' }}>Sesi {{ $i }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-3 mt-md-0">
                    <button type="submit" class="btn btn-warning btn-block font-weight-bold shadow-sm">
                        <i class="fas fa-search mr-2"></i> Tampilkan
                    </button>
                </div>
                <div class="col-md-3 mt-3 mt-md-0">
                    <button type="button" onclick="exportExcel()" class="btn-action btn-excel btn-block font-weight-bold shadow-sm">
                        <i class="fas fa-file-excel mr-2"></i> Export Excel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div style="display: none;">
        <select name="id_kelas">
            <option value="{{ Auth::user()->id_kelas }}" selected>
                {{ Auth::user()->kelas->nama_kelas ?? 'Kelas Guru' }}
            </option>
        </select>
    </div>

    <div class="announcement-card border-secondary shadow overflow-hidden">
        <div class="table-responsive">
            <table class="data-table table-striped table-hover mb-0">
                <thead>
                    <tr class="bg-secondary text-white text-center">
                        <th class="text-center">No</th>
                        <th>Nama Siswa</th>
                        <th class="text-center">H</th>
                        <th class="text-center">S</th>
                        <th class="text-center">I</th>
                        <th class="text-center">A</th>
                    </tr>
                </thead>
                <tbody>
                    @if(request('id_tahun_ajaran'))
                        @forelse($siswa as $index => $r)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="font-weight-bold">{{ $r->nama_siswa }}</div>
                            </td>
                            <td class="text-center text-success font-weight-bold">{{ $r->hadir }}</td>
                            <td class="text-center text-info font-weight-bold">{{ $r->sakit }}</td>
                            <td class="text-center text-warning font-weight-bold">{{ $r->izin }}</td>
                            <td class="text-center text-danger font-weight-bold">{{ $r->alpa }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center p-4">Data tidak ditemukan untuk periode ini.</td>
                        </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="7" class="text-center p-4 text-muted">
                                <i class="fas fa-info-circle mr-2"></i> Silahkan pilih tahun ajaran dan sesi terlebih dahulu, lalu klik "Tampilkan".
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('guru.dashboard') }}" class="btn-logout-user btn-block text-center d-block">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
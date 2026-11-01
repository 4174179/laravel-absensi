@extends('layouts.admin')

@section('title', 'Ganti Periode Ajaran')

@section('content')
<header class="main-header">
    <h2><i class="fas fa-calendar-alt"></i> Ganti Periode Ajaran</h2>
</header>

<main class="main-content">
    <div class="card">
        <h3><i class="fas fa-plus-circle"></i> Tambah Master Periode Akademik</h3>
        <form action="{{ route('admin.periode.tahun.store') }}" method="POST" class="filter-form">
            @csrf
            <div class="filter-group" style="width: 100%;">
                <label>Format Tahun Ajaran</label>
                <input type="text" name="tahun" placeholder="Contoh: 2026/2027" required class="input-search" style="width: 100%;">
                @error('tahun') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <button type="submit" class="btn-filter" style="margin-top: 25px;"><i class="fas fa-save"></i> Simpan Periode</button>
        </form>

        <div style="margin-top: 20px; max-height: 150px; overflow-y: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <th>Status Sistem</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_tahun as $thn)
                    <tr>
                        <td>{{ $thn->tahun }}</td>
                        <td>
                            @if($thn->is_aktif)
                            <span style="color: #2ecc71; font-weight: bold;"><i class="fas fa-check-circle"></i> SEDANG AKTIF</span>
                            @else
                            <span style="color: #94a3b8;">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if(!$thn->is_aktif)
                            <form action="{{ route('admin.periode.tahun.aktifkan', $thn->id_tahun_ajaran) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-edit" style="background: #27ae60; padding: 4px 8px; font-size: 0.8rem;">
                                    <i class="fas fa-power-off"></i> Aktifkan
                                </button>
                            </form>
                            @else
                            <button class="btn-edit" style="background: #7f8c8d; padding: 4px 8px; font-size: 0.8rem; cursor: not-allowed;" disabled>
                                Active
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-top: 20px;">
        <h3><i class="fas fa-exchange-alt"></i> Eksekusi Transisi Periode Akademik</h3>

        <form action="{{ route('admin.periode.proses') }}" method="POST" id="formGantiPeriode">
            @csrf
            <div class="table-controls" style="display: flex; gap: 15px; align-items: flex-end; justify-content: flex-start; margin-bottom: 20px;">
                <div class="filter-group" style="margin-bottom: 0;">
                    <label style="font-weight: bold;">Target Periode / Tahun Ajaran Baru:</label>
                    <select name="target_tahun" required class="input-search" style="border: 1px solid #e74c3c; width: 300px;">
                        <option value="">-- Pilih Periode Tujuan --</option>
                        @foreach($list_tahun as $thn)
                        @if(!$thn->is_aktif)
                        <option value="{{ $thn->id_tahun_ajaran }}">
                            {{ $thn->tahun }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="filter-group" style="margin-bottom: 0;">
                    <label style="font-weight: bold;">Filter Tampilan Kelas:</label>
                    <select id="filterKelas" class="input-search" style="width: 180px;">
                        <option value=""> Semua Kelas </option>
                        @foreach($list_kelas as $k)
                        <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="search-container" style="margin-bottom: 0; width: 250px; margin-left: auto;">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" placeholder="Cari..." class="input-search" style="width: 100%;">
                </div>
            </div>

            <table class="data-table" id="siswaTable">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 150px;">NIS</th>
                        <th>Nama Siswa</th>
                        <th style="width: 150px;">Kelas Saat Ini</th>
                        <th style="width: 350px;">Target Kelas / Status Baru</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($list_siswa as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><code>{{ $row->nis }}</code></td>
                        <td>{{ $row->nama_siswa }}</td>
                        <td style="text-align: center;"><span class="badge-blue">{{ $row->kelas->nama_kelas ?? 'Tanpa Kelas' }}</span></td>
                        <td>
                            <input type="hidden" name="siswa_pilih[]" value="{{ $row->id_siswa }}">

                            <select name="kelas_baru[{{ $row->id_siswa }}]" class="input-search" style="width: 100%; font-weight: 500;">
                                @if($row->is_tingkat_akhir)
                                <option value="lulus" style="color: #2ecc71; font-weight: bold;">LULUS (Set Status Lulus)</option>
                                <option value="tinggal" style="color: #e74c3c;">Tinggal Kelas (Tetap di {{ $row->kelas->nama_kelas ?? 'Kelas Lama' }})</option>
                                @else
                                @foreach($row->opsi_kelas_smart as $k)
                                <option value="{{ $k->id_kelas }}" style="color: #3498db;">
                                    Naik Ke: {{ $k->nama_kelas }}
                                </option>
                                @endforeach
                                <option value="tinggal">Tinggal Kelas (Tetap di {{ $row->kelas->nama_kelas ?? 'Kelas Lama' }})</option>
                                @endif
                            </select>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #94a3b8;">Tidak ada data siswa aktif di dalam sistem.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if(count($list_siswa) > 0)
            <div style="margin-top: 20px; text-align: right;">
                <button type="submit" class="btn-filter" style="background-color: #2ecc71;">
                    <i class="fas fa-check-circle"></i> Eksekusi Transisi Angkatan
                </button>
            </div>
            @endif
        </form>
    </div>
</main>

<script>
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        document.querySelectorAll('#siswaTable tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection
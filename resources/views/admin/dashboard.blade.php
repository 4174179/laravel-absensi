@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<header class="main-header">
    <h2><i class="fas {{ $icon }}"></i> {{ $sapaan }}, {{ auth()->user()->nama_lengkap }}!</h2>
</header>

<main class="main-content">
    <div class="dashboard-row">
        <div class="col-main">
            <div class="card content-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-chart-bar mr-2"></i> Perbandingan Kehadiran Antar Kelas</h5>
                    <small class="text-muted">Data Hari Ini</small>
                </div>
                <div class="card-body">
                    <div class="chart-wrapper">
                        <canvas id="chartKelas"
                            data-labels="{{ $labels_besar }}"
                            data-h="{{ $h_besar }}"
                            data-s="{{ $s_besar }}"
                            data-i="{{ $i_besar }}"
                            data-a="{{ $a_besar }}"
                            data-siswa-max="{{ $max_siswa }}">
                        </canvas>
                    </div>
                </div>
            </div>

            <div class="stats-grid mb-4">
                <div class="card stat-card blue">
                    <div class="card-icon"><i class="fas fa-user-tie"></i></div>
                    <div class="card-info">
                        <h4>{{ $total_guru ?? 0 }}</h4>
                        <p>Total Guru</p>
                    </div>
                </div>

                <div class="card stat-card green">
                    <div class="card-icon"><i class="fas fa-users"></i></div>
                    <div class="card-info">
                        <h4>{{ $total_siswa ?? 0 }}</h4>
                        <p>Total Siswa</p>
                    </div>
                </div>

                <div class="card stat-card orange">
                    <div class="card-icon"><i class="fas fa-chalkboard"></i></div>
                    <div class="card-info">
                        <h4>{{ $total_kelas ?? 0 }}</h4>
                        <p>Total Kelas</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-side">
            <div class="card content-card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-area mr-2"></i> Tren Sekolah</h5>
                </div>
                <div class="card-body">
                    <canvas id="absensiChart" data-labels='{!! $labels_kecil !!}' data-h='{!! $h_kecil !!}'
                        data-s='{!! $s_kecil !!}' data-i='{!! $i_kecil !!}' data-a='{!! $a_kecil !!}'
                        data-max='{{ $total_siswa ?? 100 }}' style="height: 200px;">
                    </canvas>
                </div>
            </div>

            <div class="card content-card">
                <div class="card-header">
                    <h5 class="m-0 d-flex align-items-center">
                        <i class="fas fa-bullhorn mr-2"></i>
                        <span>Pengumuman</span>
                        <button type="button" class="btn-sm-plus ml-2" onclick="openAddModal()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="announcement-container">
                        <ul class="list-announcement" id="announcement-list">
                            @if(isset($pengumuman) && count($pengumuman) > 0)
                            @foreach($pengumuman as $row)
                            @php
                            $dot_class = "dot-info";
                            if ($row->kategori == 'penting')
                            $dot_class = "dot-penting";
                            if ($row->kategori == 'agenda')
                            $dot_class = "dot-agenda";
                            @endphp
                            <li class="announcement-item" data-pengumuman="{{ json_encode($row) }}"
                                onclick="openDetail(this)" style="cursor: pointer;">
                                <div class="status-dot {{ $dot_class }}"></div>
                                <div class="announcement-text judul-text" title="{{ $row->judul }}">
                                    {{ $row->judul }}
                                </div>
                                <div class="announcement-time">
                                    {{ \Carbon\Carbon::parse($row->tgl_tampil)->translatedFormat('d F') }}
                                </div>
                            </li>
                            @endforeach
                            @else
                            <li class="text-center py-4"><i class="fas fa-info-circle mb-2"></i>Tidak ada pengumuman
                                terbaru</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><i class="fas fa-info-circle"></i> Pengumuman otomatis dihapus setelah 14
                        hari.</small>
                </div>
            </div>
        </div>
    </div>
</main>

<div id="modalTambah" class="modal-overlay hidden">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-lg font-bold text-gray-800">Tambah Pengumuman Baru</h3>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Judul</label>
                <input type="text" id="add-judul" class="modal-input" placeholder="Masukkan judul...">
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select id="add-kategori" class="modal-input">
                    <option value="info">Info (Biru)</option>
                    <option value="penting">Penting (Merah)</option>
                    <option value="agenda">Agenda (Hijau)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Tampil</label>
                <input type="date" id="add-tgl" class="modal-input">
            </div>
            <div class="form-group">
                <label class="form-label">Isi Pengumuman</label>
                <textarea id="add-isi" rows="5" class="modal-input resize-none"
                    placeholder="Tulis pengumuman..."></textarea>
            </div>
        </div>
        <div class="modal-footer flex justify-end gap-2">
            <button onclick="closeAddModal()" class="btn-reset">Batal</button>
            <button onclick="saveNew()" class="btn-save">Tambah Sekarang</button>
        </div>
    </div>
</div>

<div id="modalPengumuman" class="modal-overlay hidden">
    <div class="modal-content">
        <!-- Header -->
        <div class="modal-header">
            <h3 id="modalTitle" class="mode-view">Detail Pengumuman</h3>
            <div class="mode-edit hidden w-full">
                <label class="form-label">Judul Pengumuman</label>
                <input type="text" id="edit-judul" class="modal-input" placeholder="Judul Pengumuman">
            </div>
        </div>

        <!-- Body -->
        <div class="modal-body">
            <!-- View Mode -->
            <div class="mode-view">
                <p id="view-isi" class="view-text"></p>
                <div class="view-meta-container">
                    <span id="view-badge"></span>
                    <span id="view-tgl"></span>
                </div>
            </div>

            <!-- Edit Mode -->
            <div class="mode-edit hidden">
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select id="edit-kategori" class="modal-input">
                        <option value="info">Info (Biru)</option>
                        <option value="penting">Penting (Merah)</option>
                        <option value="agenda">Agenda (Hijau)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Tampil</label>
                    <input type="date" id="edit-tgl" class="modal-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Isi Pengumuman</label>
                    <textarea id="edit-isi" rows="6" class="modal-input resize-none"></textarea>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
            <input type="hidden" id="target-id">

            <div class="mode-view flex justify-between">
                <div class="flex gap-2">
                    <button onclick="window.closeModal()" class="btn-reset">Tutup</button>
                    <button onclick="window.confirmDelete(null, null, 'pengumuman')" class="btn-delete">Hapus</button>
                    <button onclick="window.toggleEditMode(true)" class="btn-edit">Edit</button>
                </div>
            </div>

            <div class="mode-edit hidden justify-end gap-2">
                <button onclick="window.toggleEditMode(false)" class="btn-reset">Batal</button>
                <button onclick="window.saveUpdate()" class="btn-save">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection
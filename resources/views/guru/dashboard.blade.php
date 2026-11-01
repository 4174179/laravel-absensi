@extends('layouts.guru') {{-- Panggil rangka guru yang bersih tanpa sidebar --}}

@section('title', 'Guru Dashboard')

@section('content')
    <main class="main-content">

        <div class="user-header-card">
            <h2><i class="fas fa-chalkboard-teacher mr-2"></i> Dashboard <strong>Guru</strong></h2>
            <p>{{ auth()->user()->kelas->nama_kelas ?? 'Kelas Tidak Terdaftar' }}</p>
        </div>

        <div class="clock-card">
            <span id="digital-clock" class="font-weight-bold">23:59:59</span>
            <span class="text-light">{{ date('l, d F Y') }}</span>
        </div>

        <div class="button-grid">
            <a href="javascript:void(0)" id="btn-mulai-absen" data-url="{{ route('guru.confirm') }}"
                onclick="confirmCekLibur()" class="btn-user btn-orange">
                <i class="fas fa-hand-paper"></i> Mulai Absen
            </a>

            <a href="{{ route('guru.rekap') }}" class="btn-user btn-green">
                <i class="fas fa-file-alt"></i> Rekap Absen
            </a>
        </div>

        <div class="announcement-card">
            <span class="announcement-header"><i class="fas fa-bullhorn mr-2"></i>Pengumuman</span>
            <div class="announcement-list">
                <div class="pengumuman-scroll-area">
                    @forelse($pengumuman as $row)
                        <div class="pengumuman-item p-3 mb-2 border-bottom border-secondary"
                            data-pengumuman="{{ json_encode($row) }}" onclick="openDetail(this)" style="cursor:pointer;">
                            <div class="d-flex align-items-center mb-1">
                                <span class="status-dot dot-{{ $row->kategori }} mr-2"></span>
                                <h5 class="m-0 font-weight-bold">{{ $row->judul }}</h5>
                            </div>
                            <p class="mb-1 text-truncate">{{ $row->isi }}</p>
                            <small class="text-muted">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ \Carbon\Carbon::parse($row->tgl_tampil)->format('d M Y') }}
                            </small>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>Tidak ada informasi terbaru</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>


        <button class="btn-logout-user" onclick="confirmLogout()">
            <i class="fas fa-sign-out-alt"></i> logout
        </button>
    </main>

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
                <!-- Footer -->
                <div class="modal-footer">
                    <input type="hidden" id="target-id">

                    <div class="mode-view flex justify-between">
                        <div class="flex gap-2">
                            <button onclick="closeModal()" class="btn-reset">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
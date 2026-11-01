@extends('layouts.guru')

@section('title', 'Konfirmasi Sesi')

@section('content')
<div class="main-content">
    <div class="clock-card">
        <h4 class="fw-bold">Konfirmasi Sesi Absensi</h4>
        <p class="text-light">Kelas: <strong>{{ auth()->user()->kelas->nama_kelas ?? 'N/A' }}</strong></p>
    </div>

    <div class="session-list">
        @forelse ($list_sesi as $sesi)
        @php
        $is_done = in_array($sesi->id_sesi, $sesi_selesai);
        $jam_sekarang = date('H:i:s');
        $is_terlambat = ($jam_sekarang > $sesi->jam_tutup) && !$is_done;
        @endphp

        <div class="card card-session {{ $is_done ? 'completed' : 'active' }}">
            <div class="card-body p-4 text-center">

                {{-- Status Badge --}}
                @if ($is_done)
                <div class="status-badge status-done">
                    TERKUNCI / SUDAH TERISI
                </div>
                @elseif ($is_terlambat)
                <div class="status-badge" style="background: #fff3cd; color: #856404; border: 1px solid #ffeeba;">
                    <i class="fas fa-exclamation-triangle"></i> SESI LEWAT (ABSEN SUSULAN)
                </div>
                @else
                <div class="status-badge status-pending">
                    BISA DIISI (ON-TIME)
                </div>
                @endif

                <h2 class="mb-1">{{ $sesi->nama_sesi }}</h2>
                <p class="text-muted small mb-3">
                    <i class="far fa-clock"></i> Jam Operasional: {{ \Carbon\Carbon::parse($sesi->jam_buka)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->jam_tutup)->format('H:i') }} WIB
                </p>

                @if ($is_done)
                {{-- Sesi Sudah Terisi --}}
                <button class="btn btn-secondary w-100 btn-session disabled mb-2" disabled style="opacity: 0.7; cursor: not-allowed;">
                    <i class="fas fa-lock"></i> Sesi Terkunci
                </button>

                <a href="{{ route('guru.input-absen', ['jam' => $sesi->id_sesi, 'edit' => 'true']) }}" class="edit-link text-decoration-none">
                    <i class="fas fa-edit"></i> Ubah Data {{ $sesi->nama_sesi }}
                </a>
                @elseif ($is_terlambat)
                {{-- Tombol Absen Susulan (Kirim status_sesi = Telat) --}}
                <a href="{{ route('guru.input-absen', ['jam' => $sesi->id_sesi, 'status_sesi' => 'Telat']) }}" class="btn btn-warning w-100 btn-session shadow-sm text-dark fw-bold">
                    <i class="fas fa-history"></i> Absen Susulan
                </a>
                @else
                {{-- Tombol Absen Normal (Kirim status_sesi = Tepat Waktu) --}}
                <a href="{{ route('guru.input-absen', ['jam' => $sesi->id_sesi, 'status_sesi' => 'Tepat Waktu']) }}" class="btn btn-primary w-100 btn-session shadow-sm">
                    <i class="fas fa-pen"></i> Mulai Absen
                </a>
                @endif

            </div>
        </div>
        @empty
        <div class="card w-100 text-center p-4">
            <i class="fas fa-clock fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Belum Ada Sesi Dibuka Saat Ini</h4>
            <p class="text-muted mb-0">Sesi absensi akan otomatis muncul di sini begitu jam operasional dimulai.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        <a href="{{ route('guru.dashboard') }}" class="btn-logout-user">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
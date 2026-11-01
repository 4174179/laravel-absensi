@extends('layouts.guru')

@section('title', 'Input Absensi')

@section('content')
{{-- ================================================================= --}}
{{-- 1. OVERLAY GATE VALIDASI (GPS + QR/PIN KELAS)                     --}}
{{-- ================================================================= --}}
<div id="validation-overlay"
    data-lat="{{ config('services.sekolah.lat') }}"
    data-long="{{ config('services.sekolah.long') }}"
    data-radius="{{ config('services.sekolah.radius') }}"
    data-pin="{{ $siswa->first()->kelas->kode_pin ?? 'K3-88' }}"
    data-redirect-url="{{ route('guru.dashboard') }}"
    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.95); z-index: 9999; display: flex; align-items: center; justify-content: center;">

    <div class="card p-4 text-center text-dark" style="max-width: 450px; width: 90%; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">

        {{-- Status Loading GPS --}}
        <div id="gps-loading-status" class="py-3">
            <div class="spinner-border text-warning mb-3" role="status"></div>
            <h5>Mengecek Lokasi GPS...</h5>
            <p class="text-muted small mb-0">Pastikan izin lokasi (GPS) pada browser Anda sudah aktif.</p>
        </div>

        {{-- Modal Scan QR (HP) --}}
        <div id="modal-qr-container" style="display: none;">
            <h4 class="fw-bold"><i class="fas fa-qrcode text-warning"></i> Scan QR Code Kelas</h4>
            <p class="text-muted small">Arahkan kamera ke QR Code kelas.</p>

            <div id="reader" class="mb-3" style="width: 100%; min-height: 250px; background: #000; border-radius: 8px; overflow: hidden;"></div>

            <button type="button" onclick="switchToPinModal()" class="btn btn-outline-warning btn-block btn-sm py-2">
                <i class="fas fa-keyboard mr-1"></i> Input PIN Manual
            </button>

            <hr class="my-3 border-secondary">

            <a href="{{ route('guru.dashboard') }}" class="btn-logout-user">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>

        {{-- Modal Input PIN (Laptop) --}}
        <div id="modal-pin-container" style="display: none;">
            <h4 class="fw-bold"><i class="fas fa-key text-warning"></i> Masukkan PIN Kelas</h4>
            <p class="text-muted small mb-3">Ketik kode PIN yang tertera di bawah QR code kelas.</p>

            <div class="form-group mb-3">
                <input type="text" id="pin_input" class="form-control text-center fw-bold fs-4" placeholder="Masukkan PIN Kelas" style="letter-spacing: 3px; text-transform: uppercase;" autocomplete="off">
            </div>

            <button type="button" onclick="submitPinManual()" class="btn btn-warning btn-block font-weight-bold py-2 mb-2">
                <i class="fas fa-check-circle mr-1"></i> Verifikasi PIN
            </button>

            <button type="button" onclick="switchToQrModal()" class="btn btn-outline-warning btn-block btn-sm py-2">
                <i class="fas fa-camera mr-1"></i> Gunakan Kamera (Scan QR)
            </button>

            <hr class="my-3 border-secondary">

            <a href="{{ route('guru.dashboard') }}" class="btn-logout-user">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>


{{-- ================================================================= --}}
{{-- 2. FORM UTAMA ABSENSI (DI-HIDE SAMPAI LOLOS VALIDASI GPS & QR)    --}}
{{-- ================================================================= --}}
<div id="main-absen-container" class="main-content" style="display: none;">
    <div class="user-header-card">
        <h4 class="text-warning mb-0">
            <i class="fas fa-user-check text-warning mr-2"></i> Absensi Kelas:
            <span class="text-warning">{{ auth()->user()->kelas->nama_kelas ?? 'N/A' }}</span>
        </h4>
        <div class="text-right">
            <small class="text-header d-block">Sesi Ke:</small>
            <span class="badge badge-warning px-3 py-2">{{ $jam }}</span>
        </div>
    </div>

    <form action="{{ route('guru.simpan-absen') }}{{ request('edit') ? '?edit=true' : '' }}" method="POST" id="formAbsensi">
        @csrf
        <input type="hidden" name="jam_pelajaran" value="{{ $jam }}">
        <input type="hidden" name="status_sesi" value="{{ request('status_sesi', $status_sesi ?? 'Tepat Waktu') }}">

        {{-- --- INPUT HIDDEN UTAMA --- --}}
        @foreach($siswa as $s)
        @php
        $absensi_today = $s->absensi->first();
        $current_status = $absensi_today->status ?? 'H';
        $current_ket = $absensi_today->keterangan ?? '';
        @endphp
        <input type="hidden" name="id_siswa[]" value="{{ $s->id_siswa }}">
        <input type="hidden" name="status[]" id="hidden-status-{{ $s->id_siswa }}" value="{{ $current_status }}">
        <input type="hidden" name="keterangan[]" id="hidden-ket-{{ $s->id_siswa }}" value="{{ $current_ket }}">
        @endforeach

        {{-- --- VERSI DESKTOP --- --}}
        <div class="announcement-card border-secondary d-none d-md-block shadow">
            <div class="card-body p-0">
                <table class="data-table table-striped table-hover mb-0">
                    <thead>
                        <tr class="bg-secondary text-white">
                            <th class="text-center" width="5%">No</th>
                            <th width="35%">Nama Siswa</th>
                            <th width="25%">Status</th>
                            <th width="35%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $index => $s)
                        @php
                        $absensi_today = $s->absensi->first();
                        $current_status = $absensi_today->status ?? 'H';
                        $current_ket = $absensi_today->keterangan ?? '';
                        @endphp
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="font-weight-bold">{{ $s->nama_siswa }}</div>
                                <small class="text-muted">{{ $s->nis }}</small>
                            </td>
                            <td>
                                <select class="form-control input-sync" data-id="{{ $s->id_siswa }}" data-type="status"
                                    onchange="window.syncStatus('{{ $s->id_siswa }}', this.value)">
                                    <option value="H" {{ $current_status == 'H' ? 'selected' : '' }}>Hadir</option>
                                    <option value="S" {{ $current_status == 'S' ? 'selected' : '' }}>Sakit</option>
                                    <option value="I" {{ $current_status == 'I' ? 'selected' : '' }}>Izin</option>
                                    <option value="A" {{ $current_status == 'A' ? 'selected' : '' }}>Alpa</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control input-sync" data-id="{{ $s->id_siswa }}"
                                    data-type="ket" value="{{ $current_ket }}" onkeyup="window.syncKet('{{ $s->id_siswa }}', this.value)">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- --- VERSI MOBILE --- --}}
        <div class="d-md-none">
            @foreach($siswa as $s)
            @php
            $absensi_today = $s->absensi->first();
            $current_status = $absensi_today->status ?? 'H';
            $current_ket = $absensi_today->keterangan ?? '';
            @endphp
            <div class="card border-secondary mb-3 shadow-sm border-left-warning bg-dark">
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-warning mb-0">{{ $s->nama_siswa }}</h6>
                        <small class="text-light">{{ $s->nis }}</small>
                    </div>
                    <div class="form-group">
                        <label class="small text-white">Status Kehadiran:</label>
                        <select class="form-control input-sync" data-id="{{ $s->id_siswa }}" data-type="status"
                            onchange="window.syncStatus('{{ $s->id_siswa }}', this.value)">
                            <option value="H" {{ $current_status == 'H' ? 'selected' : '' }}>Hadir</option>
                            <option value="S" {{ $current_status == 'S' ? 'selected' : '' }}>Sakit</option>
                            <option value="I" {{ $current_status == 'I' ? 'selected' : '' }}>Izin</option>
                            <option value="A" {{ $current_status == 'A' ? 'selected' : '' }}>Alpa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="small text-white">Keterangan:</label>
                        <input type="text" class="form-control input-sync" data-id="{{ $s->id_siswa }}" data-type="ket"
                            value="{{ $current_ket }}" onkeyup="window.syncKet('{{ $s->id_siswa }}', this.value)">
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" id="btn-simpan-absen" class="btn btn-warning btn-block btn-lg shadow font-weight-bold py-3">
                <i class="fas fa-save mr-2"></i> SIMPAN ABSENSI SEKARANG
            </button>
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('guru.dashboard') }}" class="btn-logout-user">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </form>
</div>
<button type="button" id="btn-float-scroll" class="btn btn-warning shadow-lg d-md-none" onclick="window.scrollToSimpan()" style="display: none;">
    <i class="fas fa-arrow-down fa-lg"></i>
</button>
@endsection
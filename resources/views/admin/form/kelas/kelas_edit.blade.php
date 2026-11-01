@extends('layouts.admin')

@section('title', 'Edit Data Kelas')

@section('content')
<header class="main-header">
    <h2><i class="fas fa-edit"></i> Edit Data Kelas: <strong>{{ $kelas->nama_kelas }}</strong></h2>
</header>

<main class="main-content">
    <div class="card card-form">
        <form action="{{ route('kelas.update', $kelas->id_kelas) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                    required>
                @error('nama_kelas') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- TAMBAHKAN DROPDOWN TINGKAT SD TERKUNCI BERIKUT --}}
            <div class="form-group">
                <label for="tingkat">Tingkat Kelas</label>
                <select id="tingkat" disabled required>
                    @foreach (range(1, 6) as $tgl)
                    <option value="{{ $tgl }}" {{ old('tingkat', $kelas->tingkat) == $tgl ? 'selected' : '' }}>
                        Tingkat {{ $tgl }}
                    </option>
                    @endforeach
                </select>
                <input type="hidden" name="tingkat" value="{{ $kelas->tingkat }}">
            </div>

            <div class="form-group">
                <label for="id_user">Wali Kelas</label>
                <select name="id_user" id="id_user" class="form-control" required>
                    <option value="">-- Pilih Wali Kelas --</option>
                    @if(isset($list_guru))
                    @foreach ($list_guru as $guru)
                    <option value="{{ $guru->id_user }}"
                        {{ old('id_user', $kelas->id_user ?? '') == $guru->id_user ? 'selected' : '' }}>
                        {{ $guru->nama_lengkap }}
                    </option>
                    @endforeach
                    @endif
                </select>
                <small class="text-muted d-block mt-1">Ganti wali kelas jika ada perubahan.</small>
                @error('id_user')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="kode_kelas">Kode PIN Kelas</label>
                <input type="text" name="kode_kelas" id="kode_kelas" value="{{ old('kode_pin', $kelas->kode_pin) }}"
                     required>
                @error('kode_kelas') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-check"></i> Update Data
                </button>
                <a href="{{ route('kelas_manage') }}" class="btn-reset"
                    style="text-decoration: none; display: inline-block;">Batal</a>
            </div>
        </form>
    </div>
</main>
@endsection
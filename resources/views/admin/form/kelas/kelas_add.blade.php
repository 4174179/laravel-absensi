@extends('layouts.admin')

@section('title', 'Tambah Data Kelas')

@section('content')
    <header class="main-header">
        <h2><i class="fas fa-plus-circle"></i> Tambah Data Kelas</h2>
    </header>

    <main class="main-content">
        <div class="card card-form">
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas</label>
                    <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas') }}"
                        placeholder="Misal: Kelas 1 A atau 6B" required>
                    @error('nama_kelas') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="tingkat">Tingkat Kelas</label>
                    <select name="tingkat" id="tingkat" required>
                        <option value="">-- Pilih Tingkat --</option>
                        @foreach (range(1, 6) as $tgl)
                            <option value="{{ $tgl }}" {{ old('tingkat') == $tgl ? 'selected' : '' }}>
                                Tingkat {{ $tgl }}
                            </option>
                        @endforeach
                    </select>
                    @error('tingkat') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <!-- DI SINI PERUBAHAN UTAMANYA -->
                <div class="form-group">
                    <label for="id_user">Wali Kelas</label>
                    <select name="id_user" id="id_user" required>
                        <option value="">-- Pilih Wali Kelas --</option>
                        @if(isset($list_guru))
                            @foreach ($list_guru as $guru)
                                @php
                                    // Cek apakah guru sudah terikat dengan relasi kelas
                                    $isWalas = $guru->kelas ? true : false;
                                @endphp

                                <option value="{{ $guru->id_user }}" 
                                    {{ $isWalas ? 'disabled' : '' }}
                                    {{ old('id_user') == $guru->id_user ? 'selected' : '' }}>
                                    
                                    {{ $guru->nama_lengkap }} {{ $isWalas ? '(Walas ' . $guru->kelas->nama_kelas . ')' : '' }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('id_user') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="kode_kelas">Kode PIN Kelas</label>
                    <input type="text" name="kode_kelas" id="kode_kelas" value="{{ old('kode_kelas') }}"
                        placeholder="Misal: K3-88" required>
                    @error('kode_kelas') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Simpan Data Kelas
                    </button>
                    <a href="{{ route('kelas_manage') }}" class="btn-reset"
                        style="text-decoration: none; display: inline-block;">Batal</a>
                </div>
            </form>
        </div>
    </main>
@endsection
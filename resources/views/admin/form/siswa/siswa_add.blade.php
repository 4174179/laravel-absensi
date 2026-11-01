@extends('layouts.admin')

@section('title', 'Tambah Data Siswa')

@section('content')
<header class="main-header">
    <h2><i class="fas fa-user-plus"></i> Tambah Data Siswa</h2>
</header>

<main class="main-content">
    <div class="card card-form">
        <form action="{{ route('siswa.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="nis">NIS (Nomor Induk Siswa)</label>
                <input type="text" name="nis" id="nis" value="{{ old('nis') }}" placeholder="Contoh: 2024001" required>
                @error('nis') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="nama_siswa">Nama Lengkap Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" value="{{ old('nama_siswa') }}" placeholder="Masukkan nama lengkap" required>
                @error('nama_siswa') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="" disabled {{ old('jenis_kelamin') == '' ? 'selected' : '' }}>-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="id_kelas">Pilih Kelas</label>
                <select name="id_kelas" id="id_kelas" required>
                    <option value="" disabled {{ old('id_kelas') == '' ? 'selected' : '' }}>-- Pilih Kelas --</option>
                    @if(isset($list_kelas))
                        @foreach ($list_kelas as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ old('id_kelas') == $kls->id_kelas ? 'selected' : '' }}>
                                {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('id_kelas') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Data Siswa
                </button>
                <a href="{{ route('siswa_manage') }}" class="btn-reset" style="text-decoration: none; display: inline-block;">Batal</a>
            </div>

        </form>
    </div>
</main>
@endsection
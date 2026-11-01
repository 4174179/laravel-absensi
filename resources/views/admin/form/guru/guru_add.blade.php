@extends('layouts.admin')

@section('title', 'Tambah Data Guru')

@section('content')
<header class="main-header">
    <h2><i class="fas fa-user-plus"></i> Tambah Data Guru</h2>
</header>

<main class="main-content">
    <div class="card card-form">
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif
        <form action="{{ route('guru.store') }}" method="POST">
            @csrf 

            <div class="form-group">
                <label>Nama Lengkap Guru</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Contoh: Budi Setiawan, S.Pd" required>
                @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Username (untuk Login)</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: budi123" required>
                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Data Guru
                </button>
                <a href="{{ route('guru_manage') }}" class="btn-reset" style="text-decoration: none; display: inline-block;">Batal</a>
            </div>
        </form>
    </div>
</main>
@endsection
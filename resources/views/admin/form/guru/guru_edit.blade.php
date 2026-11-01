@extends('layouts.admin')

@section('title', 'Edit Guru: ' . $guru->nama_lengkap)

@section('content')
<header class="main-header">
    <h2><i class="fas fa-user-edit"></i> Edit Data Guru: <strong>{{ $guru->nama_lengkap }}</strong></h2>
</header>

<main class="main-content">
    <div class="card card-form">
        
        <form action="{{ route('guru.update', $guru->id_user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Lengkap Guru</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" required>
                @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Username (Login)</label>
                <input type="text" name="username" value="{{ old('username', $guru->username) }}" required>
                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Password Baru (Kosongkan jika tidak ingin ganti)</label>
                <input type="password" name="password" placeholder="Masukkan password baru jika ingin ganti">
                <small class="text-muted">Biarkan kosong jika tetap menggunakan password lama.</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-sync"></i> Update Data Guru
                </button>
                <a href="{{ route('guru_manage') }}" class="btn-reset" style="text-decoration: none; display: inline-block;">Batal</a>
            </div>
        </form>
    </div>
</main>
@endsection
@extends('layouts.admin')

@section('title', 'Edit Data Siswa')

@section('content')
    <header class="main-header">
        <h2><i class="fas fa-user-edit"></i> Edit Data Siswa: <strong>{{ $siswa->nama_siswa }}</strong></h2>
    </header>

    <main class="main-content">
        <div class="card card-form">
            <form action="{{ route('siswa.update', $siswa->id_siswa) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nis">NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}" required>
                    @error('nis') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="nama_siswa">Nama Lengkap Siswa</label>
                    <input type="text" name="nama_siswa" id="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                        required>
                    @error('nama_siswa') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" required>
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki
                        </option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                    @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="id_kelas">Pilih Kelas</label>
                    <select name="id_kelas" id="id_kelas" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($list_kelas as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ (old('id_kelas', $siswa->id_kelas) == $kls->id_kelas) ? 'selected' : '' }}>
                                {{ $kls->nama_kelas }}
                                (Wali: {{ $kls->waliKelas->nama_lengkap ?? 'Belum ada' }})
                            </option>
                        @endforeach
                        </select>
                        @error('id_kelas') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-check"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('siswa_manage') }}" class="btn-reset"
                        style="text-decoration: none; display: inline-block;">Batal</a>
                </div>
            </form>
        </div>
    </main>
@endsection
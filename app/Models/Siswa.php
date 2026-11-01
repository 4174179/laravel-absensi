<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $fillable = ['nis', 'nama_siswa', 'jenis_kelamin', 'id_kelas', 'status', 'id_tahun_ajaran'];

    // Relasi: Siswa milik satu Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function absensi()
    {
        // Relasi: Satu Siswa punya banyak catatan Absensi
        return $this->hasMany(Absensi::class, 'id_siswa', 'id_siswa');
    }

    public function riwayatAkademik()
    {
        return $this->hasMany(RiwayatAkademik::class, 'id_siswa');
    }
}
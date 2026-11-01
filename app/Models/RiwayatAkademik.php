<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAkademik extends Model
{
    use HasFactory;

    protected $table = 'riwayat_akademik';
    protected $primaryKey = 'id_riwayat';

    protected $fillable = [
        'id_siswa',
        'nis',
        'nama_siswa',
        'id_kelas',
        'id_tahun_ajaran'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $fillable = ['nama_kelas', 'tingkat', 'id_user','kode_pin'];

    // Relasi: Satu Kelas punya satu Wali Kelas (User)
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas', 'id_kelas');
    }
}
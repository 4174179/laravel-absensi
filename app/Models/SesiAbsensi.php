<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiAbsensi extends Model
{
    use HasFactory;

    protected $table = 'sesi_absensi';
    protected $primaryKey = 'id_sesi';

    protected $fillable = [
        'nama_sesi',
        'jam_buka',
        'jam_tutup',
        'is_active',
    ];
}
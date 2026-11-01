<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'tb_pengumuman'; 
    protected $primaryKey = 'id_pengumuman'; 
    protected $fillable = ['judul', 'kategori', 'isi', 'tgl_tampil'];
    public $timestamps = false;
}
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // Nama tabel
    protected $primaryKey = 'id_user'; // Nama kolom Primary Key lo

    protected $fillable = [
        'nama_lengkap', 'username', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function kelas()
{
    return $this->hasOne(Kelas::class, 'id_user', 'id_user');
}
}
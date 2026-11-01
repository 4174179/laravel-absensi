<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_pengumuman', function (Blueprint $table) {
            $table->id('id_pengumuman');
            $table->string('judul');
            $table->text('isi');    
            $table->enum('kategori', ['penting', 'info','agenda'])->default('info');
            $table->date('tgl_tampil');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pengumuman');
    }
};

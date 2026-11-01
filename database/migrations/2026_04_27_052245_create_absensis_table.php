<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('id_absensi');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_tahun_ajaran')->nullable();
            $table->date('tgl_absen');
            $table->enum('status', ['H', 'S', 'I', 'A']);
            $table->text('keterangan')->nullable();
            $table->tinyInteger('sesi');
            $table->timestamps();
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->unique(['id_siswa', 'tgl_absen', 'sesi'], 'unik_absen');

            $table->foreign('id_tahun_ajaran')->references('id_tahun_ajaran')->on('tahun_ajaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};

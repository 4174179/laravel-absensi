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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->unsignedBigInteger('id_kelas')->nullable();
            $table->unsignedBigInteger('id_tahun_ajaran')->nullable();
            $table->string('nis', 20)->unique();
            $table->string('nama_siswa', 100);
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->enum('status', ['aktif', 'lulus'])->default('aktif');
            $table->timestamps();

            $table->foreign('id_tahun_ajaran')->references('id_tahun_ajaran')->on('tahun_ajaran')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};

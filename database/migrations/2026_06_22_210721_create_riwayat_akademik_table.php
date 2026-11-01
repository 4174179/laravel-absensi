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
        Schema::create('riwayat_akademik', function (Blueprint $table) {
            $table->id('id_riwayat'); 

            $table->foreignId('id_siswa')
                  ->nullable() 
                  ->constrained('siswa', 'id_siswa')
                  ->onDelete('set null');

            $table->string('nis')->nullable(); 
            $table->string('nama_siswa');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();

            $table->foreignId('id_kelas')
                  ->constrained('kelas', 'id_kelas')
                  ->onDelete('cascade');
                  
            $table->foreignId('id_tahun_ajaran')
                  ->constrained('tahun_ajaran', 'id_tahun_ajaran')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_akademik');
    }
};
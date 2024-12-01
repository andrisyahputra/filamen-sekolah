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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nisn');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tgl_lahir_siswa');
            $table->string('tempat_lahir_siswa');
            $table->date('tahun_ajaran_daftar');
            // $table->foreignId('id_kelas')->constrained('kelas')->nullable();
            // $table->foreignId('id_ibu')->constrained('keluarga')->nullable();
            // $table->foreignId('id_ayah')->constrained('keluarga')->nullable();
            // $table->foreignId('id_wali')->constrained('keluarga')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
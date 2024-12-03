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
        Schema::table('siswas', function (Blueprint $table) {
            //
            $table->string('anak_berapa')->nullable();

            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->string('tanggal_lahir_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();
            $table->text('alamat_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('kk')->nullable();
            $table->string('gambar_ayah')->nullable();

            $table->string('nama_ibu')->nullable();
            $table->string('tempat_lahir_ibu')->nullable();
            $table->string('tanggal_lahir_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();
            $table->text('alamat_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('gambar_ibu')->nullable();

            $table->string('nama_wali')->nullable();
            $table->string('tempat_lahir_wali')->nullable();
            $table->string('tanggal_lahir_wali')->nullable();
            $table->string('no_hp_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->string('gambar_wali')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            //
            $table->dropColumn('nama_ayah');
            $table->dropColumn('tempat_lahir_ayah');
            $table->dropColumn('tanggal_lahir_ayah');
            $table->dropColumn('no_hp_ayah');
            $table->dropColumn('alamat_ayah');
            $table->dropColumn('pekerjaan_ayah');
            $table->dropColumn('pendidikan_ayah');
            $table->dropColumn('nik_ayah');
            $table->dropColumn('kk');
            $table->dropColumn('gambar_ibu');
            $table->dropColumn('nama_ibu');
            $table->dropColumn('tempat_lahir_ibu');
            $table->dropColumn('tanggal_lahir_ibu');
            $table->dropColumn('no_hp_ibu');
            $table->dropColumn('alamat_ibu');
            $table->dropColumn('pekerjaan_ibu');
            $table->dropColumn('pendidikan_ibu');
            $table->dropColumn('nik_ibu');
            $table->dropColumn('gambar_ibu');
            $table->dropColumn('nama_wali');
            $table->dropColumn('tempat_lahir_wali');
            $table->dropColumn('tanggal_lahir_wali');
            $table->dropColumn('no_hp_wali');
            $table->dropColumn('alamat_wali');
            $table->dropColumn('pekerjaan_wali');
            $table->dropColumn('pendidikan_wali');
            $table->dropColumn('nik_wali');
            $table->dropColumn('gambar_wali');
            $table->dropColumn('anak_berapa');
        });
    }
};
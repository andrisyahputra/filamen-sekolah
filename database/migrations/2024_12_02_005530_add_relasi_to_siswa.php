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
        Schema::table('siswas', function (Blueprint $table) {
            //
            $table->foreignId('id_kelas')->constrained('kelas')->nullable();
            $table->foreignId('id_ibu')->constrained('ibus')->nullable();
            $table->foreignId('id_ayah')->constrained('ayahs')->nullable();
            $table->foreignId('id_wali')->constrained('walis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            //
            $table->dropColumn('id_kelas');
            $table->dropColumn('id_ibu');
            $table->dropColumn('id_ayah');
            $table->dropColumn('id_wali');
        });
    }
};
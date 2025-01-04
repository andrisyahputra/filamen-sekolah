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
            // $table->dropForeign(['id_ayah']);
            // Hapus kolom
            // $table->dropColumn('id_ayah');
            // $table->dropForeign(['id_ibu']);
            // Hapus kolom
            // $table->dropColumn('id_ibu');
            // $table->dropForeign(['id_wali']);
            // // Hapus kolom
            // $table->dropColumn('id_wali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            //
            // $table->foreignId('id_ibu')->nullable()->constrained('ibus');
            // $table->foreignId('id_ayah')->nullable()->constrained('ayahs');
            // $table->foreignId('id_wali')->nullable()->constrained('walis');
        });
    }
};

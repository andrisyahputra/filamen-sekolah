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
        Schema::table('gurus', function (Blueprint $table) {
            //
            $table->integer('jenis_guru')->default('0');
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            //
            $table->dropColumn('jenis_guru');
            $table->dropForeign(['jabatan_id']);
            // Hapus kolom
            $table->dropColumn('jabatan_id');
        });
    }
};

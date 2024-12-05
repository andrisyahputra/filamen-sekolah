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
        Schema::table('kategori_transaksis', function (Blueprint $table) {
            //
            $table->renameColumn('jenis_tranksaksi', 'jenis_transaksi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_transaksis', function (Blueprint $table) {
            //
            $table->renameColumn('jenis_transaksi', 'jenis_tranksaksi');
        });
    }
};
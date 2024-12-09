<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    //

    protected $guarded = ['id'];
    /**
     * Get the kategori_transaksi that owns the KategoriTransaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori_transaksi(): BelongsTo
    {
        return $this->belongsTo(KategoriTransaksi::class, 'kategori_transaksis_id', 'id');
    }
    public function getKategoriTransaksiJenisAttribute(): string
    {
        // Pastikan kategori_transaksi ada sebelum mengaksesnya
        if ($this->kategori_transaksi->jenis_transaksi) {
            return "{$this->kategori_transaksi->name} - (Pengeluaran)";
        }

        return "{$this->kategori_transaksi->name} - (Pemasukkan)";
    }
    public function scopePengeluaran($query)
    {
        return $this->whereHas('kategori_transaksi', function ($query) {
            $query->where('jenis_transaksi', false);
        });
    }
    public function scopePemasukkan($query)
    {
        return $this->whereHas('kategori_transaksi', function ($query) {
            $query->where('jenis_transaksi', true);
        });
    }

}

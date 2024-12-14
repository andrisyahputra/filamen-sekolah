<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Transaksi extends Model
{
    //

    protected $guarded = ['id'];

    // Automatically set user_id during creation if not provided
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Only set user_id if it's not already set and a user is authenticated
            if (!$model->user_id && Auth::check()) {
                $model->user_id = Auth::id();
            }
        });
    }
    /**
     * Get the kategori_transaksi that owns the KategoriTransaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori_transaksi(): BelongsTo
    {
        return $this->belongsTo(KategoriTransaksi::class, 'kategori_transaksis_id', 'id');
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}

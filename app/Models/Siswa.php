<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    //
    protected $guarded = ['id'];
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
    public function ayah(): BelongsTo
    {
        return $this->belongsTo(Ayah::class);
    }
    public function ibu(): BelongsTo
    {
        return $this->belongsTo(Ibu::class);
    }
    public function wali(): BelongsTo
    {
        return $this->belongsTo(Wali::class);
    }
}
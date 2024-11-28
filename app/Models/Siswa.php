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
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengurus extends Model
{
    //
    protected $guarded = ['id'];
    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class);
    }
}
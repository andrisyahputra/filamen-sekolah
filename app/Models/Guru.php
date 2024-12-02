<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guru extends Model
{
    //
    protected $guarded = ['id'];

    public function mataPelajarans()
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mata_pelajaran', 'guru_id', 'mata_pelajaran_id');
    }
    public function guruKelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_kelas', 'guru_id', 'kelas_id');
    }
}
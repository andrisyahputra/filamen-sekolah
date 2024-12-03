<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    //
    protected $guarded = ['id'];
    // public function kelas(): BelongsTo
    // {
    //     return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    // }
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa', 'siswa_id', 'kelas_id');
    }
    // public function ayah(): BelongsTo
    // {
    //     return $this->belongsTo(Ayah::class, 'id_ayah', 'id');
    // }
    // public function ibu(): BelongsTo
    // {
    //     return $this->belongsTo(Ibu::class, 'id_ibu', 'id');
    // }
    // public function wali(): BelongsTo
    // {
    //     return $this->belongsTo(Wali::class, 'id_wali', 'id');
    // }


}
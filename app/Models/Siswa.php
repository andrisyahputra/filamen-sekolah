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
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
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


    public function ayah(): BelongsTo
    {
        return $this->belongsTo(Ayah::class, 'id_ayah', 'id')
            ->selectRaw("id, CONCAT(name, ' - ', nik) as name_and_nik")
            ->orderByRaw("CONCAT(name, ' - ', nik) ASC");
    }
    public function ibu(): BelongsTo
    {
        return $this->belongsTo(Ibu::class, 'id_ibu', 'id')
            ->selectRaw("id, CONCAT(name, ' - ', nik) as name_and_nik")
            ->orderByRaw("CONCAT(name, ' - ', nik) ASC");
    }
    public function wali(): BelongsTo
    {
        return $this->belongsTo(Wali::class, 'id_wali', 'id')
            ->selectRaw("id, CONCAT(name, ' - ', nik) as name_and_nik")
            ->orderByRaw("CONCAT(name, ' - ', nik) ASC");
    }
}
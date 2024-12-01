<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    //
    protected $guarded = ['id'];
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mata_pelajaran', 'mata_pelajaran_id', 'guru_id');
    }
}
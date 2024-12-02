<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    //
    protected $guarded = ['id'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id');
    }
    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa', 'kelas_id', 'siswa_id');
    }

}
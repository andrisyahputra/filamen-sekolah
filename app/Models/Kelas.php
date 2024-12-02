<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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

    // public function assignToKelas($kelasId)
    // {
    //     if ($this->kelas()->exists()) {
    //         throw new \Exception('Siswa sudah terdaftar di kelas lain.');
    //     }

    //     $this->kelas()->attach($kelasId);
    // }
    public static function validateUniqueSiswa(array $siswaIds, $id)
    {
        // dd($id);
        // Cari siswa yang sudah memiliki kelas
        // $cek = DB::table('kelas_siswa')
        //     ->whereIn('siswa_id', $siswaIds)
        //     ->where('kelas_id', '!=', $id);
        // // Debug query SQL yang dihasilkan

        // $jumlah = $cek->count();
        // if ($jumlah > 0) {

        //     $alreadyAssigned = Siswa::whereHas('kelas')
        //         ->whereIn('id', $siswaIds)
        //         ->where('kelas_id', '!=', $id)
        //         ->pluck('name')
        //         ->toArray();

        //     if (!empty($alreadyAssigned)) {
        //         $errorMessage = 'Siswa berikut sudah memiliki kelas: ' . implode(', ', $alreadyAssigned);

        //         throw ValidationException::withMessages([
        //             'siswas' => $errorMessage,
        //         ]);
        //     }
        // }
        $alreadyAssigned = Siswa::whereHas('kelas', function ($query) use ($id) {
            $query->where('kelas_id', '!=', $id); // Pastikan kelas yang sama tidak dihitung
        })
            ->whereIn('id', $siswaIds)
            ->pluck('name')
            ->toArray();

        if (!empty($alreadyAssigned)) {
            $errorMessage = 'Siswa berikut sudah terdaftar di kelas lain: ' . implode(', ', $alreadyAssigned);

            throw ValidationException::withMessages([
                'siswas' => $errorMessage,
            ]);
        }
    }

}

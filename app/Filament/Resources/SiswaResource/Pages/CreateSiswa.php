<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use App\Models\Kelas;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateSiswa extends CreateRecord
{

    protected static string $resource = SiswaResource::class;

    public ?int $kelasId = null; // To hold the kelasId

    public ?Kelas $kelas = null; // Property to hold the Kelas instance


    public function mount(): void
    {
        // Capture the kelasId parameter from the route
        $this->kelasId = request()->get('record');
        $this->kelas = Kelas::find($this->kelasId);
        // dd($this->kelasId);
    }
    public function getTitle(): string|Htmlable
    {
        // Ambil data kelas yang sedang diedit
        // Ubah judul sesuai dengan data kelas
        return 'Tambah Siswa  ' . ucwords(($this->kelas ? $this->kelas->name : 'Unknown Kelas'));
    }


    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Automatically associate the new siswa with the selected kelas
    //     if ($this->kelasId) {
    //         $data['kelas_id'] = $this->kelasId; // Make sure 'kelas_id' is the correct column in the siswa table
    //     }
    //     return $data;
    // }

    // protected function getRedirectUrl(): string
    // {
    //     return $this->resource::getUrl('index');
    // }
}

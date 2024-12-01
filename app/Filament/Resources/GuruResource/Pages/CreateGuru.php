<?php

namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGuru extends CreateRecord
{
    protected static string $resource = GuruResource::class;
    protected function afterCreate(): void
    {
        // Menyinkronkan mata pelajaran yang dipilih setelah guru dibuat
        $guru = $this->record;

        // Mendapatkan ID mata pelajaran dari request yang dipilih
        $mataPelajaranIds = $this->data['id_mata_pelajaran']; // Mengambil data dari form yang sudah disubmit

        // Menyinkronkan mata pelajaran yang dipilih
        if (!empty($mataPelajaranIds)) {
            $guru->mataPelajarans()->sync($mataPelajaranIds);
        }
    }
}
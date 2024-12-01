<?php

namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuru extends EditRecord
{
    protected static string $resource = GuruResource::class;
    protected function afterSave(): void
    {
        $guru = $this->record;

        // Mendapatkan ID mata pelajaran yang dipilih dari form
        $mataPelajaranIds = $this->data['id_mata_pelajaran'];

        // Menyinkronkan mata pelajaran yang dipilih
        if (!empty($mataPelajaranIds)) {
            $guru->mataPelajarans()->sync($mataPelajaranIds);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
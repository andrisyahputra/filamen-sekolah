<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditKelas extends EditRecord
{
    protected static string $resource = KelasResource::class;

    public function getTitle(): string|Htmlable
    {
        // Ambil data kelas yang sedang diedit
        $kelas = $this->record;

        // Ubah judul sesuai dengan data kelas
        return 'Atur  ' . ($kelas->name ?? 'Tanpa Nama');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
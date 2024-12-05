<?php

namespace App\Filament\Resources\KategoriTransaksiResource\Pages;

use App\Filament\Resources\KategoriTransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriTransaksi extends EditRecord
{
    protected static string $resource = KategoriTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\KategoriTransaksiResource\Pages;

use App\Filament\Resources\KategoriTransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriTransaksis extends ListRecords
{
    protected static string $resource = KategoriTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

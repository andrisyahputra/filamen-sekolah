<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use App\Models\Kelas;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class ByKelasSiswa extends Page
{

    protected static string $resource = SiswaResource::class;


    protected static string $view = 'filament.pages.siswa-index';



    // Ubah tipe properti menjadi Collection
    public Collection $kelas;

    public function mount()
    {
        // Ambil data kelas sebagai objek Eloquent Collection
        $this->kelas = Kelas::all();
    }
    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }


}

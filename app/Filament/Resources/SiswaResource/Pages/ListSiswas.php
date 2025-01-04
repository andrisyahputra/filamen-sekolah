<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use App\Models\Kelas;
use App\Models\Siswa;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Contracts\Support\Htmlable;


class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    public ?int $kelasId = null;  // Property to hold the kelasId value
    public ?Kelas $kelas = null;

    public function mount(): void  // No parameters here, the value is fetched via the route
    {
        $this->kelasId = request()->route('record');
        $this->kelas = Kelas::find($this->kelasId);
    }
    public function getTitle(): string|Htmlable
    {
        return 'Siswa  ' . ucwords(($this->kelas ? $this->kelas->name : 'Unknown Kelas'));
    }
    protected function getTableQuery(): ?Builder
    {
        // Use your Siswa model and add any necessary filters based on the kelasId
        return Siswa::query()
            ->when($this->kelasId, function ($query) {
                return $query->whereHas('kelas', function ($query) {
                    $query->where('kelas.id', $this->kelasId);
                });
            });
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(route('filament.admin.resources.siswas.create', ['record' => $this->kelasId])), // Pass kelasId as a query parameter
        ];
    }
}

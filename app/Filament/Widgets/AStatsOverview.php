<?php
namespace App\Filament\Widgets;

use App\Models\Siswa;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AStatsOverview extends BaseWidget
{

    protected function getColumns(): int
    {
        return 2; // Atur menjadi 2 kolom
    }

    protected function getStats(): array
    {
        $jumlahLakiLaki = Siswa::where('jenis_kelamin', 'L')->count();
        $jumlahPerempuan = Siswa::where('jenis_kelamin', 'P')->count();

        return [
            Stat::make('Jumlah Laki-Laki', $jumlahLakiLaki)
                ->description('Siswa berjenis kelamin laki-laki')
                ->color('primary'),

            Stat::make('Jumlah Perempuan', $jumlahPerempuan)
                ->description('Siswa berjenis kelamin perempuan')
                ->color('secondary'),


        ];
    }
}
<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;

use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BStatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $startDate = !is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            now();

        $endDate = !is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            $startDate->copy()->addMonth();
        $pengeluaran = Transaksi::pengeluaran()->whereBetween('tgl_transaksi', [$startDate, $endDate])->sum('jumlah');
        $pemasukan = Transaksi::pemasukkan()->whereBetween('tgl_transaksi', [$startDate, $endDate])->sum('jumlah');
        // $pemasukan = Transaksi::pemasukkan()->get()->sum('amount');
        // $pengeluaran = Transaksi::where('is_expense', false)->sum('amount');
        return [
            //
            Stat::make('Total Masuk', 'Rp ' . number_format($pemasukan, 0, ',', '.')),
            Stat::make('Total Keluar', 'Rp ' . number_format($pengeluaran, 0, ',', '.')),
            Stat::make('Selisih', 'Rp ' . number_format($pemasukan - $pengeluaran, 0, ',', '.')),
        ];
    }
}

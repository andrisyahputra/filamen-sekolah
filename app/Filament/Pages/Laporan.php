<?php

namespace App\Filament\Pages;

use App\Models\Transaksi;
use Filament\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\View;

class Laporan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.laporan';

    public ?string $start_date = null;
    public ?string $end_date = null;

    public static function getNavigationGroup(): string
    {
        return 'Data Keuangan';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public function mount(): void
    {
        $this->form->fill([
            'start_date' => now()->startOfMonth()->toDateString(),
            'end_date' => now()->endOfMonth()->toDateString(),
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()->schema([
                Grid::make()->columns(2)->schema([
                    DatePicker::make('start_date')
                        ->required()
                        ->label('Start Date')
                        ->reactive(),
                    DatePicker::make('end_date')
                        ->required()
                        ->label('End Date')
                        ->reactive(),
                ]),
            ]),
        ];
    }

    public function print()
    {

        $data = [
            'start_date' => request()->get('start_date'),
            'end_date' => request()->get('end_date'),
            // 'records' => $this->getReportData(),
        ];

        $data['records'] = Transaksi::with('kategori_transaksi')->whereBetween('tgl_transaksi', [request()->get('start_date'), request()->get('end_date')])->get();
        //  $record->kategori_transaksi->jenis_transaksi == true di tambah jika false di kurang
        // $data['total_jumlah'] = $data['records']->sum('jumlah');


        return view('filament.pages.laporan-print', $data);
    }

    protected function getReportData(): array
    {
        // Simulasi data laporan
        return [
            ['id' => 1, 'name' => 'Laporan 1', 'amount' => 1000],
            ['id' => 2, 'name' => 'Laporan 2', 'amount' => 2000],
        ];
    }
}
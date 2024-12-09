<?php

namespace App\Filament\Pages;

use App\Models\Pengurus;
use App\Models\Transaksi;
use Filament\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
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

    public $bulan; // Tambahkan properti untuk menyimpan nilai bulan

    public function mount(): void
    {
        // Set nilai awal bulan saat ini
        $this->bulan = now()->month;
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()->schema([
                Grid::make()->columns(2)->schema([
                    Select::make('bulan')
                        ->label('Pilih Bulan')
                        ->options([
                            '1' => 'Januari',
                            '2' => 'Februari',
                            '3' => 'Maret',
                            '4' => 'April',
                            '5' => 'Mei',
                            '6' => 'Juni',
                            '7' => 'Juli',
                            '8' => 'Agustus',
                            '9' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'Desember',
                        ])
                        ->required()
                        ->placeholder('Pilih Bulan')
                        ->reactive() // Perbarui properti saat nilai berubah
                        ->default($this->bulan) // Tetapkan default berdasarkan properti
                        ->afterStateUpdated(fn($state) => $this->bulan = $state), // Perbarui nilai properti saat dipilih
                ]),
            ]),
        ];
    }

    public function print()
    {

        $data = [
            'bulan' => formatBulan(request()->get('bulan')),
            // 'end_date' => request()->get('end_date'),
            // 'records' => $this->getReportData(),
        ];

        $data['records'] = Transaksi::with('kategori_transaksi')->whereMonth('tgl_transaksi', request()->get('bulan'))->get();
        $data['saldo_awal'] = Transaksi::with('kategori_transaksi')
            ->whereMonth('tgl_transaksi', '<', request()->get('bulan'))
            ->sum('jumlah');
        // dd($data['saldo_awal']);
        // $data['records'] = Transaksi::with('kategori_transaksi')->whereBetween('tgl_transaksi', [request()->get('start_date'), request()->get('end_date')])->get();
        // $data['ketua_umum'] = Pengurus::with('jabatan')->whereLike('jabatans.name', '%ketua umum')->first();
        $data['ketua_umum'] = Pengurus::whereHas('jabatan', function ($query) {
            $query->where('name', 'like', '%ketua umum%');
        })->with('jabatan')->first();
        $data['bendahara'] = Pengurus::whereHas('jabatan', function ($query) {
            $query->where('name', 'like', '%bendahara sekolah%');
        })->with('jabatan')->first();
        $data['kepala_sekolah'] = Pengurus::whereHas('jabatan', function ($query) {
            $query->where('name', 'like', '%kepala sekolah%');
        })->with('jabatan')->first();
        // $data['kepala_sekolah'] = Pengurus::with('jabatan')->whereLike('jabatans.name', '%bendahara sekolah%')->first();
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

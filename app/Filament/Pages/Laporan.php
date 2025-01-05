<?php

namespace App\Filament\Pages;

use App\Models\Transaksi;
use App\Models\Pengurus;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Route;

class Laporan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.laporan';

    public ?string $bulan = null;

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
        // Set default to current month
        $this->bulan = now()->month;
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()->schema([
                Grid::make()->columns(1)->schema([
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
                        ->reactive()
                        ->default($this->bulan)
                        ->afterStateUpdated(fn($state) => $this->bulan = $state),
                ]),
            ]),
        ];
    }

    public function create_print_sekolah()
    {
        return redirect()->route('laporan.print_sekolah', ['bulan' => $this->bulan]);
    }

    public function create_print_danabos()
    {
        return redirect()->route('laporan.print_danabos', ['bulan' => $this->bulan]);
    }

    public function create_print_bkm()
    {
        return redirect()->route('laporan.print_bkm', ['bulan' => $this->bulan]);
    }

    public function print_sekolah($bulan)
    {
        $data = $this->prepareReportData($bulan, 'sekolah');
        $pdf = Pdf::loadView('filament.pages.laporan-print-sekolah', $data);
        // Set ukuran kertas A4 dan margin
        $pdf->setPaper('A4', 'portrait'); // Ukuran A4, orientasi potrait


        // Menampilkan PDF di browser
        return $pdf->stream('laporan-keuangan-sekolah.pdf');
        // return view('filament.pages.laporan-print-sekolah', $data);
    }

    public function print_danabos($bulan)
    {
        $data = $this->prepareReportData($bulan, 'danabos');
        $pdf = Pdf::loadView('filament.pages.laporan-print-danabos', $data);
        // Set ukuran kertas A4 dan margin
        $pdf->setPaper('A4', 'portrait'); // Ukuran A4, orientasi potrait


        // Menampilkan PDF di browser
        return $pdf->stream('laporan-keuangan-danabos.pdf');
        // return view('filament.pages.laporan-prin
        // return view('filament.pages.laporan-print-danabos', $data);
    }

    public function print_bkm($bulan)
    {
        $data = $this->prepareReportData($bulan, 'bkm');
        $pdf = Pdf::loadView('filament.pages.laporan-print-bkm', $data);
        // Set ukuran kertas A4 dan margin
        $pdf->setPaper('A4', 'portrait'); // Ukuran A4, orientasi potrait


        // Menampilkan PDF di browser
        return $pdf->stream('laporan-keuangan-bkm.pdf');
        // return view('filament.pages.laporan-prin
        // return view('filament.pages.laporan-print-bkm', $data);
    }

    protected function prepareReportData($bulan, $tipe)
    {
        $lastMonth = Carbon::create(null, $bulan)->subMonth();
        $lastMonthNumber = $lastMonth->month;
        $lastYearNumber = $lastMonth->year;
        $saldoAwal = Transaksi::where(function ($query) use ($lastMonthNumber, $lastYearNumber) {
            $query->whereMonth('tgl_transaksi', $lastMonthNumber)
                ->whereYear('tgl_transaksi', $lastYearNumber); // Filter bulan dan tahun sebelumnya
        })
            ->when($tipe === 'sekolah', function ($query) {
                return $query->whereHas('kategori_transaksi', function ($q) {
                    $q->where('tipe', '1');
                });
            })
            ->when($tipe === 'danabos', function ($query) {
                return $query->whereHas('kategori_transaksi', function ($q) {
                    $q->where('tipe', '2');
                });
            })
            ->when($tipe === 'bkm', function ($query) {
                return $query->whereHas('kategori_transaksi', function ($q) {
                    $q->where('tipe', '3');
                });
            });

        // Total pemasukkan
        $totalPemasukkan = $saldoAwal->clone()->pemasukkan()->sum('jumlah');

        // Total pengeluaran
        $totalPengeluaran = $saldoAwal->clone()->pengeluaran()->sum('jumlah');

        // Saldo awal dihitung
        $saldoAwal = $totalPemasukkan - $totalPengeluaran;

        $data = [
            'bulan' => formatBulan($bulan), // Format nama bulan
            'records' => Transaksi::with('kategori_transaksi')
                ->whereMonth('tgl_transaksi', $bulan) // Filter bulan ini
                ->when($tipe === 'sekolah', function ($query) {
                    return $query->whereHas('kategori_transaksi', function ($q) {
                        $q->where('tipe', '1');
                    });
                })
                ->when($tipe === 'danabos', function ($query) {
                    return $query->whereHas('kategori_transaksi', function ($q) {
                        $q->where('tipe', '2');
                    });
                })
                ->when($tipe === 'bkm', function ($query) {
                    return $query->whereHas('kategori_transaksi', function ($q) {
                        $q->where('tipe', '3');
                    });
                })
                ->get(),
            'saldo_awal' => $saldoAwal,
            'ketua_umum' => Pengurus::whereHas('jabatan', function ($query) {
                $query->where('name', 'like', '%ketua umum%');
            })->with('jabatan')->first(),
            'bendahara' => Pengurus::whereHas('jabatan', function ($query) {
                $query->where('name', 'like', '%bendahara sekolah%');
            })->with('jabatan')->first(),
            'kepala_sekolah' => Pengurus::whereHas('jabatan', function ($query) {
                $query->where('name', 'like', '%kepala sekolah%');
            })->with('jabatan')->first(),
        ];

        return $data;
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


        // return view('filament.pages.laporan-print', $data);
        // Render view menjadi PDF
        $pdf = Pdf::loadView('filament.pages.laporan-print', $data);

        // Menampilkan PDF di browser
        return $pdf->stream('laporan-keuangan.pdf');
    }
}

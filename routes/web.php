<?php

use App\Filament\Pages\Laporan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect('admin/login');
});


Route::get('/laporan', [Laporan::class, 'index'])->name('laporan.index');
// Route::get('/laporan/print', [Laporan::class, 'print'])->name('laporan.print');
Route::get('/laporan/print-sekolah/{bulan}', [Laporan::class, 'print_sekolah'])
    ->name('laporan.print_sekolah');

Route::get('/laporan/print-danabos/{bulan}', [Laporan::class, 'print_danabos'])
    ->name('laporan.print_danabos');

Route::get('/laporan/print-bkm/{bulan}', [Laporan::class, 'print_bkm'])
    ->name('laporan.print_bkm');
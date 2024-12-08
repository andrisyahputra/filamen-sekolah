<?php

use App\Filament\Pages\Laporan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect('admin/login');
});


Route::get('/laporan', [Laporan::class, 'index'])->name('laporan.index');
Route::get('/laporan/print', [Laporan::class, 'print'])->name('laporan.print');

<?php

namespace App\Filament\Exports;

use App\Models\Siswa;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SiswaExporter extends Exporter
{
    protected static ?string $model = Siswa::class;
    protected static int $rowNumber = 0;


    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('No.')
                ->state(function ($record) {
                    static::$rowNumber++;
                    return static::$rowNumber;
                }),
            ExportColumn::make('name')
                ->label('nama'),
            ExportColumn::make('nisn'),
            ExportColumn::make('jenis_kelamin'),
            ExportColumn::make('tgl_lahir_siswa'),
            ExportColumn::make('tempat_lahir_siswa'),
            ExportColumn::make('tahun_ajaran_daftar'),
            ExportColumn::make('gambar'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('anak_berapa'),
            ExportColumn::make('nama_ayah'),
            ExportColumn::make('nik_ayah'),
            ExportColumn::make('tempat_lahir_ayah'),
            ExportColumn::make('tanggal_lahir_ayah'),
            ExportColumn::make('no_hp_ayah'),
            ExportColumn::make('alamat_ayah'),
            ExportColumn::make('pekerjaan_ayah'),
            ExportColumn::make('pendidikan_ayah'),
            ExportColumn::make('kk'),
            ExportColumn::make('gambar_ayah'),
            ExportColumn::make('nama_ibu'),
            ExportColumn::make('tempat_lahir_ibu'),
            ExportColumn::make('tanggal_lahir_ibu'),
            ExportColumn::make('no_hp_ibu'),
            ExportColumn::make('alamat_ibu'),
            ExportColumn::make('pekerjaan_ibu'),
            ExportColumn::make('pendidikan_ibu'),
            ExportColumn::make('nik_ibu'),
            ExportColumn::make('gambar_ibu'),
            ExportColumn::make('nama_wali'),
            ExportColumn::make('tempat_lahir_wali'),
            ExportColumn::make('tanggal_lahir_wali'),
            ExportColumn::make('no_hp_wali'),
            ExportColumn::make('alamat_wali'),
            ExportColumn::make('pekerjaan_wali'),
            ExportColumn::make('pendidikan_wali'),
            ExportColumn::make('nik_wali'),
            ExportColumn::make('gambar_wali'),
            ExportColumn::make('tahun_ajaran'),
            ExportColumn::make('status_siswa'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your siswa export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

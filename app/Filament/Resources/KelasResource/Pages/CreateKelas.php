<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use App\Models\Kelas;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateKelas extends CreateRecord
{

    protected static string $resource = KelasResource::class;
    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        // Ambil data siswa yang dipilih
        $siswaIds = $this->data['siswas'];  // Pastikan form memiliki field 'siswas'

        try {
            // Validasi siswa yang sudah memiliki kelas
            Kelas::validateUniqueSiswa($siswaIds);  // Panggil fungsi validasi yang sudah dibuat

            // Lanjutkan proses penyimpanan jika validasi berhasil
            parent::save($shouldRedirect, $shouldSendSavedNotification); // Panggil parent save untuk menyimpan data

        } catch (ValidationException $e) {
            // Tampilkan notifikasi jika ada siswa yang sudah terdaftar di kelas lain
            Notification::make()
                ->title('Error')
                ->body($e->errors()['siswas'][0])  // Menampilkan pesan error pertama
                ->danger()
                ->send();

            // Batalkan penyimpanan jika ada error
            return;
        }
    }
}

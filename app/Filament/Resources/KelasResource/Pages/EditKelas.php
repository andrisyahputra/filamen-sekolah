<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use App\Models\Kelas;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class EditKelas extends EditRecord
{
    protected static string $resource = KelasResource::class;

    public function getTitle(): string|Htmlable
    {
        // Ambil data kelas yang sedang diedit
        $kelas = $this->record;

        // Ubah judul sesuai dengan data kelas
        return 'Atur  ' . ($kelas->name ?? 'Tanpa Nama');
    }

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        // Ambil data siswa yang dipilih
        $siswaIds = $this->data['siswas'];  // Pastikan form memiliki field 'siswas'
        $kelas = $this->getRecord(); // Mengambil record (model) yang sedang diedit
        $idKelas = $kelas ? $kelas->id : null; // Pastikan bahwa kelas tidak null

        // dd($idKelas);
        try {
            // Validasi siswa yang sudah memiliki kelas
            Kelas::validateUniqueSiswa($siswaIds, $idKelas);  // Panggil fungsi validasi yang sudah dibuat

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
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
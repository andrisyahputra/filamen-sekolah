<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Filament\Resources\GuruResource\RelationManagers;
use App\Models\Guru;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): string
    {
        return 'Data Guru'; // Nama grup
    }
    public static function getNavigationSort(): ?int
    {
        return 1; // Nilai kecil untuk prioritas tinggi
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nip_pns')
                    ->label('NIP')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik_swasta')
                    ->label('NIK')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->required(),
                // Forms\Components\TextInput::make('alamat')
                //     ->required()
                //     ->maxLength(255),
                Forms\Components\TextInput::make('pendidikan_terakhir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('gambar'),
                Forms\Components\MultiSelect::make('id_mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->relationship('mataPelajarans', 'name') // Pastikan 'mataPelajarans' sesuai dengan nama relasi di model Guru
                    ->required(),
                Forms\Components\Select::make('jenis_guru')
                    ->label('Jenis Guru')
                    ->options([
                        '1' => 'Guru Madrasah',
                        '2' => 'Guru PAUD',
                        '3' => 'HONOR',
                    ])
                    ->required()
                    ->placeholder('Pilih Jeni Guru'),
                Forms\Components\Select::make('status_guru')
                    ->label('Status Guru')
                    ->options([
                        '1' => 'PNS',
                        '2' => 'PPPK',
                        '3' => 'HONOR',
                    ])
                    ->required()
                    ->placeholder('Pilih Status Guru'),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('jabatan')
                    ->relationship('jabatan', 'name')
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->circular(),
                Tables\Columns\TextColumn::make('status_guru')
                    ->label('Status Guru') // Label untuk kolom
                    ->formatStateUsing(function ($state) {
                        // dd($state);
                        return match ($state) {
                            1 => 'PNS',
                            2 => 'PPPK',
                            3 => 'HONOR',
                            default => 'Tidak Diketahui',
                        };
                    }) // Format nilai numerik menjadi teks
                    ->sortable() // Tambahkan kemampuan untuk mengurutkan
                    ->searchable(), // Tambahkan kemampuan pencarian
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('status_guru')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('nip_pns')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_swasta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir')
                    ->searchable(),
                // Menampilkan mata pelajaran yang dipilih
                Tables\Columns\TextColumn::make('mataPelajarans.name')
                    ->label('Mata Pelajaran')
                    ->getStateUsing(function (Guru $guru) {
                        return $guru->mataPelajarans->pluck('name')->implode(', ');
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }
}
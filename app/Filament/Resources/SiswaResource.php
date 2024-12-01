<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): string
    {
        return 'Data Siswa'; // Nama grup
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
                Forms\Components\TextInput::make('nisn')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-Laki',
                        'P' => 'Perempuan',
                    ])
                    ->required()
                    ->placeholder('Pilih Jenis Kelamin'),
                Forms\Components\DatePicker::make('tgl_lahir_siswa')
                    ->required(),
                Forms\Components\TextInput::make('tempat_lahir_siswa')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tahun_ajaran_daftar')
                    ->required(),
                Forms\Components\TextInput::make('id_kelas')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('id_ibu')
                    ->label('Nik Ibu')
                    ->relationship('ibu', 'nik')
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('id_ayah')
                    ->label('Nik Ayah')
                    ->relationship('ayah', 'nik')
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('id_wali')
                    ->label('Nik Wali')
                    ->relationship('wali', 'nik')
                    ->preload()
                    ->searchable(),
                Forms\Components\FileUpload::make('gambar'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('tgl_lahir_siswa')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tempat_lahir_siswa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_ajaran_daftar')
                    ->date()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('id_kelas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_ibu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_ayah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_wali')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
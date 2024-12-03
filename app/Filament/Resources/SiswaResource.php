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
        // return $form
        //     ->schema([
        //         Forms\Components\TextInput::make('name')
        //             ->required()
        //             ->maxLength(255),
        //         Forms\Components\TextInput::make('nisn')
        //             ->required()
        //             ->maxLength(255),
        //         Forms\Components\Select::make('jenis_kelamin')
        //             ->label('Jenis Kelamin')
        //             ->options([
        //                 'L' => 'Laki-Laki',
        //                 'P' => 'Perempuan',
        //             ])
        //             ->required()
        //             ->placeholder('Pilih Jenis Kelamin'),
        //         Forms\Components\DatePicker::make('tgl_lahir_siswa')
        //             ->required(),
        //         Forms\Components\TextInput::make('tempat_lahir_siswa')
        //             ->required()
        //             ->maxLength(255),
        //         Forms\Components\DatePicker::make('tahun_ajaran_daftar')
        //             ->label('Pendaftaran')
        //             ->required(),
        //         Forms\Components\FileUpload::make('gambar'),

        //     ]);
        $schema = [
            Forms\Components\Section::make('Data Siswa')
                ->schema([
                    // Forms\Components\DatePicker::make('tgl_mulai')
                    //     ->required(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nisn')
                        ->label('NISN')
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
                        ->label('Pendaftaran')
                        ->required(),
                    Forms\Components\TextInput::make('tahun_ajaran')
                        ->label('Tahun Ajaran')
                        ->required()
                        ->numeric()
                        ->default(now()->year),
                    Forms\Components\TextInput::make('anak_berapa')
    ->label('Anak Ke')
    ->numeric()
    ->required(),
                    Forms\Components\DatePicker::make('kk')
                        ->label('Kartu Keluarga')
                        ->required(),

                    // Forms\Components\Textarea::make('Data Siswa')
                    //     ->required()
                    //     ->columnSpanFull(),

                ]),
        ];
        $schema[] = Forms\Components\Section::make('Data Ayah')
            ->schema([
                Forms\Components\TextInput::make('nama_ayah')
                    // ->required()
                    ->label('Nama Lengkap Ayah')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik_ayah')
                    ->label('NIK Ayah')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tempat_lahir_ayah')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir_ayah')
                ,// ->required(),
                Forms\Components\TextInput::make('no_hp_ayah')
                    ->label('NO TLP/WA Ayah')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('alamat_ayah')
                    // ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('pekerjaan_ayah')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pendidikan_ayah')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('gambar_ayah'),

            ]);
        $schema[] = Forms\Components\Section::make('Data IBU')
            ->schema([
                Forms\Components\TextInput::make('nama_ibu')
                    ->label('Nama Lengkap Ibu')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik_ibu')
                    ->label('NIK IBU')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tempat_lahir_ibu')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir_ibu')
                ,// ->required(),
                Forms\Components\TextInput::make('no_hp_ibu')
                    ->label('NO TLP/WA Ibu')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('alamat_ibu')
                    // ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('pekerjaan_ibu')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pendidikan_ibu')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('gambar_ibu'),

            ]);
        $schema[] = Forms\Components\Section::make('Data WALI')
            ->schema([
                Forms\Components\TextInput::make('nama_wali')
                    ->label('Nama Lengkap Wali')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik_wali')
                    ->label('NIK Wali')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tempat_lahir_wali')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir_wali'),
                // ->required(),
                Forms\Components\TextInput::make('no_hp_wali')
                    ->label('NO TLP/WA Wali')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('alamat_wali')
                    // ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('pekerjaan_wali')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pendidikan_wali')
                    // ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('gambar_wali'),

            ]);
        return $form->schema($schema);
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
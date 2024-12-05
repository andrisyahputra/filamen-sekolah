<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriTransaksiResource\Pages;
use App\Filament\Resources\KategoriTransaksiResource\RelationManagers;
use App\Models\KategoriTransaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriTransaksiResource extends Resource
{
    protected static ?string $model = KategoriTransaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): string
    {
        return 'Data Keuangan'; // Nama grup
    }
    public static function getNavigationSort(): ?int
    {
        return 1; // Nilai kecil untuk prioritas tinggi
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('jenis_transaksi')
                                    ->label('Jenis Transaksi')
                                    ->onColor('success') // Warna saat aktif
                                    ->offColor('danger') // Warna saat tidak aktif
                                    ->onIcon('heroicon-o-arrow-up-circle') // Ikon saat aktif
                                    ->offIcon('heroicon-o-arrow-down-circle') // Ikon saat tidak aktif
                                    ->helperText('Merah: Pengeluaran, Hijau: Pemasukkan') // Penjelasan
                                    ->required()
                            ])
                    ])
            ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                // Tables\Columns\IconColumn::make('jenis_transaksi')
                //     ->boolean(),
                Tables\Columns\IconColumn::make('jenis_transaksi')
                    ->label('Jenis  ')
                    ->boolean()
                    ->trueIcon('heroicon-o-arrow-up-circle')
                    ->falseIcon('heroicon-o-arrow-down-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
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
            'index' => Pages\ListKategoriTransaksis::route('/'),
            'create' => Pages\CreateKategoriTransaksi::route('/create'),
            'edit' => Pages\EditKategoriTransaksi::route('/{record}/edit'),
        ];
    }
}
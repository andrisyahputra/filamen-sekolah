<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Filament\Resources\KelasResource\RelationManagers;
use App\Models\Kelas;
use App\Models\Siswa;
use Dotenv\Exception\ValidationException;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    public static function getNavigationGroup(): string
    {
        return 'Data Guru'; // Nama grup
    }
    public static function getNavigationSort(): ?int
    {
        return 3; // Nilai kecil untuk prioritas tinggi
    }

    public static function form(Form $form): Form
    {
        // dd();
        return $form

            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('id_guru')
                    ->label('Wali Kelas')
                    ->relationship('guru', 'name')
                    ->preload()
                    ->searchable(),
                // Forms\Components\MultiSelect::make('id_kelas')
                //     ->label('Siswa')
                //     ->relationship('siswas', 'name') // Pastikan 'mataPelajarans' sesuai dengan nama relasi di model Guru
                //     ->required(),
                // Forms\Components\MultiSelect::make('siswas')
                //     ->label('Siswa')
                //     ->relationship('siswas', 'name')
                //     ->required()
                //     ->options(
                //         Siswa::doesntHave('kelas')->pluck('name', 'id')->toArray()
                //     ),
                // Forms\Components\MultiSelect::make('siswas')
                //     ->label('Siswa')
                //     ->relationship('siswas', 'name') // Hubungkan ke relasi di model Kelas
                //     ->required()
                //     ->options(
                //         Siswa::whereDoesntHave('kelas') // Siswa tanpa kelas
                //             ->pluck('name', 'id')
                //             ->toArray()
                //     )

                Forms\Components\MultiSelect::make('siswas')
                    ->label('Siswa')
                    ->relationship('siswas', 'name')
                    ->required()
                    ->options(
                        Siswa::doesntHave('kelas')
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->afterStateUpdated(function ($state) {
                        try {
                            return true;
                        } catch (\Illuminate\Validation\ValidationException $e) {

                            return false;
                        }
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

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
                Tables\Columns\TextColumn::make('guru.name')
                    ->label('Wali Kelas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('siswas.name')
                    ->label('Siswa Kelas')
                    ->getStateUsing(function (Kelas $kelas) {
                        return $kelas->siswas->pluck('name')->implode(', ');
                    }),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah Siswa')
                    ->getStateUsing(function (Kelas $kelas) {
                        return $kelas->siswas()->count();
                    }),

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
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }
}
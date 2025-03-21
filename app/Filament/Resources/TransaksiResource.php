<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\KategoriTransaksi;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

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
                                // Forms\Components\TextInput::make('name')
                                //     ->required()
                                //     ->maxLength(255),
                                Forms\Components\Select::make('kategori_transaksis_id')
                                    ->label('Kategori Transaksi')
                                    ->options(function () {
                                        return KategoriTransaksi::all()->mapWithKeys(function ($item) {
                                            if ($item->jenis_transaksi) {
                                                $labe = "{$item->name} - (Pemasukkan)";
                                            } else {
                                                $labe = "{$item->name} - (Pengeluaran)";
                                            }

                                            $label = $labe ?? 'Tidak Diketahui';
                                            return [$item->id => $label];
                                        });
                                    })
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                // Forms\Components\Select::make('tipe')
                                //     ->label('Status Siswa')
                                //     ->options([
                                //         '1' => 'Bendahara Sekolah',
                                //         '2' => 'Bendahara danabos',
                                //         '3' => 'Bendahara Bkm',
                                //     ])
                                //     ->default('1')
                                //     ->placeholder('Pilih Tipe Transaksi'),
                                Forms\Components\Select::make('tipe')
                                    ->label('Status Transaksi')
                                    ->options(function () {
                                        // Check if user is a super admin (show all options)
                                        if (auth()->user()->hasRole('super_admin')) {
                                            return [
                                                '1' => 'Bendahara Sekolah',
                                                '2' => 'Bendahara Dana BOS',
                                                '3' => 'Bendahara BKM',
                                            ];
                                        }

                                        // Dynamically set options based on user role
                                        $options = [];

                                        if (auth()->user()->hasRole('bendahara_sekolah')) {
                                            $options['1'] = 'Bendahara Sekolah';
                                        }

                                        if (auth()->user()->hasRole('bendahara_dana_bos')) {
                                            $options['2'] = 'Bendahara Dana BOS';
                                        }

                                        if (auth()->user()->hasRole('bendahara_bkm')) {
                                            $options['3'] = 'Bendahara BKM';
                                        }

                                        // If no specific role matched, return empty array
                                        return $options;
                                    })
                                    ->default(function () {
                                        // Set default based on user's primary role
                                        if (auth()->user()->hasRole('bendahara_sekolah')) {
                                            return '1';
                                        }

                                        if (auth()->user()->hasRole('bendahara_dana_bos')) {
                                            return '2';
                                        }

                                        if (auth()->user()->hasRole('bendahara_bkm')) {
                                            return '3';
                                        }

                                        return null;
                                    })
                                    ->placeholder('Pilih Tipe Transaksi')
                                    ->required()
                                    ->reactive(),

                                Forms\Components\DatePicker::make('tgl_transaksi')
                                    ->required(),
                                Forms\Components\TextInput::make('jumlah')
                                    ->required()
                                    ->numeric(),

                            ])
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Textarea::make('keterangan')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('gambar')
                                    ->required(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                // If super admin, show all transactions
                if ($user->hasRole('super_admin')) {
                    return $query;
                }

                // Filter based on user's specific roles
                if ($user->hasRole('bendahara_sekolah')) {
                    $query->where('tipe', '1');
                } elseif ($user->hasRole('bendahara_dana_bos')) {
                    $query->where('tipe', '2');
                } elseif ($user->hasRole('bendahara_bkm')) {
                    $query->where('tipe', '3');
                }

                return $query;
            })
            ->columns([
                // Tables\Columns\TextColumn::make('kategori_transaksis_id')
                //     ->numeric()
                //     ->sortable(),

                // Tables\Columns\TextColumn::make('name')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('kategori_transaksi.name')
                    ->label('Nama Kategori')
                    ->description(fn(Transaksi $record): string => $record->keterangan),
                Tables\Columns\IconColumn::make('kategori_transaksi.jenis_transaksi')
                    ->label('Tipe')
                    ->boolean()
                    ->trueIcon('heroicon-o-arrow-up-circle')
                    ->falseIcon('heroicon-o-arrow-down-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_transaksi')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('gambar'),
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
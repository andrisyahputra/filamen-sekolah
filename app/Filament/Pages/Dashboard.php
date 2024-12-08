<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->default(now()->subMonth()) // Default awal ke hari ini
                            ->maxDate(fn(Get $get) => $get('endDate') ?: now()->subMonth()), // Maksimum mengikuti endDate atau 1 bulan dari sekarang

                        DatePicker::make('endDate')
                            ->default(now()) // Default awal ke 1 bulan dari hari ini
                            ->minDate(fn(Get $get) => $get('startDate') ?: now()) // Minimum mengikuti startDate atau hari ini
                        // ->maxDate(now()), // Maksimum 1 bulan dari hari ini
                    ])
                    ->columns(2),
            ]);
    }
}
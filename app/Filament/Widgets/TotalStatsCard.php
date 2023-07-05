<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TotalStatsCard extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '60s';

    protected function getCards(): array
    {
        return [
            Card::make('Total Subscripciones', Registration::query()->count()),
            Card::make('Total Vendido', '$' . number_format(Registration::query()->sum('amount') / 100)),
            Card::make('Total Cobrado', '$' . number_format(Registration::query()->sum('amount_paid') / 100))
                ->color('success'),
            Card::make('Total Pendiente', '$' . number_format(Registration::query()->sum('amount_pending') / 100))
                ->color('warning'),
        ];
    }
}

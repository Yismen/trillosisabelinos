<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Payment;
use Flowframe\Trend\Trend;
use App\Models\Registration;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Collection;
use Filament\Widgets\BarChartWidget;

class MonthlyStatsChart extends BarChartWidget
{
    protected static ?string $heading = 'Registros por mes';

    protected static ?string $pollingInterval = '60s';

    protected static ?int $sort = 2;

    protected static ?array $options = [
        'interaction' => [
            'mode' => 'x',
            'intersect' => true
        ],
        'scales' => [
            'registrations' => [
                'type' => 'linear',
                'display' => true,
                'position' => 'left',
                // 'stacked' => true,
            ],
            'cashflow' => [
                'type' => 'linear',
                // 'display' => true,
                'position' => 'right',
                'stacked' => false,
            ],
            'payments' => [
                'type' => 'linear',
                'display' => false,
                'position' => 'right',
                'stacked' => true,
            ]
        ]
    ];

    protected function getData(): array
    {
        $countRegistrations = $this->countRegistrations();
        $amountSold = $this->amountSold();
        $amountPaid = $this->amountPaid();

        return [
            'datasets' => [
                [
                    'label' => 'Registros Por Mes',
                    'data' => $countRegistrations->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgb(51 112 107 / 50%)',
                    'borderColor' => 'rgb(51 112 107 / 50%)',
                    'yAxisID' => 'registrations',
                    // 'stacked' => true,
                ],
                [
                    'label' => 'Ventas Por Mes',
                    'data' => $amountSold->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgb(249, 168, 37)',
                    'borderColor' => 'rgb(249, 168, 37)',
                    'type' => 'line',
                    'tension' => 0.4,
                    'yAxisID' => 'cashflow',
                    // 'stacked' => false,
                ],
                [
                    'label' => 'Pagos Por Mes',
                    'data' => $amountPaid->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgb(101, 31, 255)',
                    'borderColor' => 'rgb(101, 31, 255)',
                    'type' => 'line',
                    'tension' => 0.4,
                    'yAxisID' => 'cashflow',
                    // 'stacked' => false,
                ],
            ],
            'labels' => $countRegistrations->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function amountSold(): Collection
    {
        return Trend::query(Sale::query())
            // ->dateColumn('date')
            ->between(
                start: $this->start(),
                end: $this->end()
            )
            ->perMonth()
            ->sum('amount')
            ->map(function ($item) {
                $item->aggregate = $item->aggregate / 100;

                return $item;
            });
    }

    protected function amountPaid(): Collection
    {
        // dd(
        //     Payment::query()
        //         ->groupBy('date')->sum('amount'),

        // );
        return Trend::query(Payment::query())
            ->dateColumn('date')
            ->dateAlias('month')
            ->between(
                start: $this->start(),
                end: $this->end()
            )
            ->perMonth()
            ->aggregate('amount', 'sum')
            ->map(function ($item) {
                $item->aggregate = $item->aggregate / 100;

                return $item;
            });
    }

    protected function countRegistrations(): Collection
    {
        return Trend::query(Registration::query())
            ->between(
                start: $this->start(),
                end: $this->end()
            )
            ->perMonth()
            ->count();
    }

    protected function start(): Carbon
    {
        return now()->subMonths(12)->startOfMonth();
    }

    protected function end(): Carbon
    {
        return now()->endOfMonth();
    }
}

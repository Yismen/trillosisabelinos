<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SalesAndPaymentsByPlanCard extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '60s';

    protected function getCards(): array
    {

        return $this->cards();
    }

    protected function cards(): array
    {
        $cards = [];

        foreach ($this->getSales() as $sale) {
            $cards[] = Card::make($sale->plan . ' Inscritos', $sale->total)
                ->color('primary');
        }

        foreach ($this->getPayments() as $payment) {
            $cards[] = Card::make($payment->plan . ' Pagos', $payment->total)
                ->color('success');
        }

        return $cards;
    }

    protected function getSales(): Collection
    {
        return DB::table('sales')
            ->leftJoin('plans', 'sales.plan_id', '=', 'plans.id')
            ->selectRaw('plans.name as plan, sum(count) as total')
            ->groupBy('plan_id')
            ->whereNull('sales.deleted_at')
            ->get();
    }

    protected function getPayments(): Collection
    {
        return DB::table('sales')
            ->leftJoin('plans', 'sales.plan_id', '=', 'plans.id')
            ->selectRaw('plans.name as plan, sum(count) as total')
            ->where('payment_id', '!=', null)
            ->whereNull('sales.deleted_at')
            ->groupBy('plan_id')
            ->get();
    }
}

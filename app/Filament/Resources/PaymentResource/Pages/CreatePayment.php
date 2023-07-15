<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Models\Sale;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PaymentResource;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function afterCreate(): void
    {
        Sale::query()
            ->whereIn('id', $this->data['sales'])
            ->update([
                'payment_id' => $this->record->id
            ]);
    }
}

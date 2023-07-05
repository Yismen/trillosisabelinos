<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use Filament\Pages\Actions;
use App\Filament\Resources\PaymentResource;
use Filament\Resources\Pages\ManageRecords;

class ManagePayments extends ManageRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

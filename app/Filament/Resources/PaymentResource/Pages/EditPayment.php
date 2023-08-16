<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PaymentResource;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('Invoice')
                ->color('primary')
                ->visible(fn () => $this->record->amount_pending == 0)
                ->url(fn () =>  route('payment.invoice.download', $this->record))
                ->openUrlInNewTab(true)

            // ->visible(fn (RelationManager $livewire) => $livewire->ownerRecord->amount_pending == 0)
            // ->url(fn (RelationManager $livewire) =>  route('payment.invoice.download', $livewire->ownerRecord->payments->first()))
            // ->openUrlInNewTab(true)
            ,
        ];
    }
}

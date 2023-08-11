<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\RegistrationResource;

class EditRegistration extends EditRecord
{
    protected static string $resource = RegistrationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),

            \Filament\Pages\Actions\Action::make('Pay')
                ->button()
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->amount_pending > 0)
                ->form([
                    DatePicker::make('date')
                        ->required()
                        ->closeOnDateSelection()
                        ->maxDate(now()->endOfDay()),
                    FileUpload::make('images')
                        ->multiple()
                        ->image()
                        ->directory('payments')
                        ->preserveFilenames()
                        ->maxSize(2000)
                        ->enableReordering()
                        ->enableOpen()
                        ->enableDownload(),
                    Textarea::make('description')
                        ->nullable(),
                    TextInput::make('amount_pending')
                        ->disabled()
                        ->formatStateUsing(function ($state, $record) {
                            return $record->amount_pending;
                        })
                ])
                ->action(function (array $data) {
                    $record = $this->record;
                    DB::transaction(function () use ($record, $data) {
                        $payment = $record->payments()
                            ->create([
                                'amount' => 0,
                                'date' => $data['date'],
                                'images' => $data['images'],
                                'description' => $data['description'],
                            ]);

                        $record->sales->each(function (Model $sale) use ($payment) {
                            $sale->update([
                                'payment_id' => $payment->id
                            ]);
                        });
                    });

                    return redirect(url()->previous());
                }),
        ];
    }
}

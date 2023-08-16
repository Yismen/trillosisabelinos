<?php

namespace App\Filament\Resources\RegistrationResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $recordTitleAttribute = 'amount';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->maxDate(now()->endOfDay()),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->disabled(),
                FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->directory('payments')
                    ->preserveFilenames()
                    ->maxSize(2000)
                    ->enableReordering()
                    ->enableOpen()
                    ->enableDownload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date(),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('code')
                    ->copyable(),
                BadgeColumn::make('images')
                    ->colors([
                        'secondary',
                        'success' => static fn ($state) => $state > 0
                    ])
                    ->getStateUsing(fn ($record) => count($record->images))

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('Invoice')
                    ->color('primary')
                    ->visible(fn (RelationManager $livewire) => $livewire->ownerRecord->amount_pending == 0)
                    ->url(fn (RelationManager $livewire) =>  route('registration.payment.invoice.download', $livewire->ownerRecord))
                    ->openUrlInNewTab(true),
                Tables\Actions\Action::make('Pay')
                    ->button()
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (RelationManager $livewire) => $livewire->ownerRecord->amount_pending > 0)
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
                            ->formatStateUsing(function (RelationManager $livewire) {
                                return $livewire->ownerRecord->amount_pending;
                            })
                    ])
                    ->action(function (array $data, RelationManager $livewire) {
                        $record = $livewire->ownerRecord;
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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}

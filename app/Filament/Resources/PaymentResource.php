<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Payment;
use App\Models\Registration;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('registration_id')
                    ->searchable()
                    ->preload()
                    ->relationship('registration', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} - {$record->amount_pending}")
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->visibleOn(['view']),
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->closeOnDateSelection()
                    ->maxDate(now()->endOfDay()),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->type('number')
                    ->required()
                    ->mask(
                        fn (\Filament\Forms\Components\TextInput\Mask $mask) => $mask
                            ->money()
                            ->numeric()
                            ->decimalPlaces(2)
                            ->minValue(0)
                            ->thousandsSeparator(','), // Add a separator for thousands.
                    )
                    ->minValue(0)
                    // ->lte('registration.amount_pending')
                    ->validationAttribute('amount'),

                Forms\Components\Textarea::make('description')
                    ->nullable(),
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
                Tables\Columns\TextColumn::make('registration.name')
                    ->getStateUsing(function (Model $record) {
                        return "{$record->registration->name} - {$record->registration->amount_pending}";
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->sortable()
                    ->searchable()
                    ->date(),
                Tables\Columns\TextColumn::make('amount')
                    ->color(function ($record) {
                        return $record->registration->amount < $record->amount ? 'danger' : '';
                    })
                    ->sortable()
                    ->searchable(),
                // ImageColumn::make('images')
                //     ->size(40)
                //     ->circular()
                // Tables\Columns\TextColumn::make('description'),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime(),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                SelectFilter::make('Registration')
                    ->searchable()
                    ->options(Registration::pluck('name', 'id'))
                    ->attribute('registration_id'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePayments::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

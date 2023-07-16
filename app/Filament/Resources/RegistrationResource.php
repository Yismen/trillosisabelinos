<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use App\Models\Registration;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use App\Enums\RegistrationStatusEnum;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Resources\RegistrationResource\RelationManagers\SalesRelationManager;
use App\Filament\Resources\RegistrationResource\RelationManagers\PaymentsRelationManager;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([

                    Forms\Components\Select::make('event_id')
                        ->relationship('event', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->exists(Event::class, 'id'),
                    Forms\Components\TextInput::make('name')
                        ->autofocus()
                        ->required()
                        ->maxLength(500)
                        ->minLength(3),
                    Forms\Components\TextInput::make('phone')
                        ->required()
                        ->tel()
                        ->maxLength(15),
                    Forms\Components\TextInput::make('email')
                        // ->required()
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('group')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('additional_phone')
                        ->tel()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('amount')
                        ->numeric()
                        ->disabled()
                        ->nullable()
                        ->minValue(0),
                    Forms\Components\TextInput::make('amount_paid')
                        ->numeric()
                        ->disabled()
                        ->nullable()
                        ->minValue(0),
                    Forms\Components\TextInput::make('amount_pending')
                        ->numeric()
                        ->disabled()
                        ->nullable()
                        ->minValue(0),
                    Forms\Components\Select::make('status')
                        ->nullable()
                        ->disabled()
                        ->options(RegistrationStatusEnum::toArray()),
                ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60 s')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('event.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->visible(false),
                TextColumn::make('group')
                    ->searchable()
                    ->visible(false),
                TextColumn::make('additional_phone')
                    ->sortable()
                    ->visible(false)
                    ->searchable(),
                TextColumn::make('amount_pending')
                    ->label('Pending')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->color(fn ($record) => $record->status === RegistrationStatusEnum::Paid->value ? 'success' : 'danger')
                    ->enum(RegistrationStatusEnum::toArray())
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('Event')
                    ->options(Event::pluck('name', 'id'))
                    ->searchable()
                    ->attribute('event_id'),
                SelectFilter::make('Status')
                    ->options(RegistrationStatusEnum::toArray()),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->withColumns([
                                // name', 'event_id', 'phone', 'email', 'group', 'additional_phone', 'amount', 'amount_paid', 'amount_pending', 'status';
                                Column::make('name'),
                                Column::make('event.name'),
                                Column::make('phone'),
                                Column::make('email'),
                                Column::make('group'),
                                Column::make('additional_phone'),
                                Column::make('amount'),
                                Column::make('amount_paid'),
                                Column::make('amount_pending'),
                                Column::make('status'),
                            ])
                            ->withFilename('Registrations')
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRegistrations::route('/'),
            'view' => Pages\ViewRegistration::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PaymentsRelationManager::class,
            SalesRelationManager::class,
        ];
    }
}

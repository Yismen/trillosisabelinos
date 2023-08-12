<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use App\Models\Registration;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use App\Enums\RegistrationStatusEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Layout\Grid;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegistrationResource\Pages;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\RegistrationResource\RelationManagers\SalesRelationManager;
use App\Filament\Resources\RegistrationResource\RelationManagers\PaymentsRelationManager;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-login';

    protected static ?string $navigationGroup = 'Event Results';

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
            // ->poll('360 s')
            ->defaultSort('created_at', 'desc')
            ->contentGrid([
                'md' => 2,
                'lg' => 3,
                'xl' => 4,
            ])
            ->columns([
                Grid::make([
                    'sm' => 1
                ])
                    ->schema([
                        Stack::make([

                            TextColumn::make('name')
                                ->label('Nombre')
                                ->getStateUsing(fn ($record) => str($record->name)->headline())
                                ->sortable()
                                ->extraAttributes(['class' => 'font-bold'])
                                ->searchable(),
                            // TextColumn::make('event.name')
                            //     ->limit(10)
                            //     ->tooltip(fn ($record) => $record->event->name)
                            //     ->sortable()
                            //     ->searchable(),
                            TextColumn::make('phone')
                                ->label('Telefono')
                                ->sortable()
                                ->searchable(),
                            TextColumn::make('group')
                                ->label('Grupo')
                                ->searchable()
                                ->sortable()
                                ->visible(true),
                            TagsColumn::make('subscriptions'),
                            TextColumn::make('payments.code')
                                ->label('Codigo')
                                ->searchable()
                                ->sortable()
                                ->getStateUsing(fn ($record) => $record->payments?->first()?->code)
                                ->copyable(),
                            TextColumn::make('amount')
                                ->label('Vendido')
                                ->formatStateUsing(fn ($state) => 'Monto Inscrito: $ ' . number_format($state))
                                ->sortable()
                                ->searchable(),
                            TextColumn::make('amount_pending')
                                ->color(fn ($record) => $record->status === RegistrationStatusEnum::Paid->value ? 'success' : 'danger')
                                ->label('Pendiente')
                                ->formatStateUsing(fn ($state) => 'Monto Pendiente: $ ' . number_format($state))
                                ->sortable()
                                ->searchable(),
                            BadgeColumn::make('status')
                                ->searchable()
                                ->sortable()
                                ->getStateUsing(fn ($record) => "Status: " . $record->status->name)
                                ->color(fn ($record) => $record->status == RegistrationStatusEnum::Paid ? 'success' : 'danger'),
                            TextColumn::make('created_at')
                                ->label('Registrado En')
                                ->date()
                                ->sortable()
                                ->searchable(),
                        ])
                    ])
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
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                FilamentExportBulkAction::make('Export'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRegistrations::route('/'),
            'view' => Pages\ViewRegistration::route('/{record}'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
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

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'phone', 'email', 'group', 'additional_phone'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }
}

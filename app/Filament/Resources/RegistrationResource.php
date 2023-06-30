<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use App\Models\Registration;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Validation\Rule;
use Filament\Resources\Resource;
use App\Enums\RegistrationStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Resources\RegistrationResource\RelationManagers;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 3;

    protected function getTablePollingInterval(): ?string
    {
        return '60s';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'name')     
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
                    ->required()
                    ->email()
                    ->maxLength(255)
                    ->unique(Registration::class, 'email'),
                Forms\Components\TextInput::make('group')
                    ->maxLength(255),
                Forms\Components\TextInput::make('additional_phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->disabled()
                    ->nullable()
                    ->minLength(0)
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount_paid')
                    ->numeric()
                    ->disabled()
                    ->nullable()
                    ->minLength(0)
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount_pending')
                    ->numeric()
                    ->disabled()
                    ->nullable()
                    ->minLength(0)
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->nullable()
                    ->disabled()
                    ->options(RegistrationStatusEnum::toArray()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('event.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->visible(false),
                Tables\Columns\TextColumn::make('group')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('additional_phone')
                    ->sortable()
                    ->visible(false)
                    ->searchable(),
                // Tables\Columns\TextColumn::make('amount')
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('amount_paid')
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('amount_pending')
                //     ->sortable()
                //     ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->enum(RegistrationStatusEnum::toArray())
                        ->sortable()
                        ->searchable(),
            ])
            ->filters([
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
            'index' => Pages\ManageRegistrations::route('/'),
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

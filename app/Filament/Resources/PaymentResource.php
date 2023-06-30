<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Payment;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationGroup;
use App\Filament\Resources\PaymentResource\RelationManagers\ImagesRelationManager;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('registration_id')
                    ->relationship('registration', 'name')
                    ->required()
                    ,
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->closeOnDateSelection()
                    ->maxDate(now()),
                Forms\Components\TextInput::make('amount')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required(),
                \Filament\Forms\Components\FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->maxSize(4000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('registration.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->sortable()
                    ->searchable()
                    ->date(),
                Tables\Columns\TextColumn::make('amount')
                    ->sortable()
                    ->searchable(),
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

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('images', [
                ImagesRelationManager::class,
            ]),
        ];
        
    }
}

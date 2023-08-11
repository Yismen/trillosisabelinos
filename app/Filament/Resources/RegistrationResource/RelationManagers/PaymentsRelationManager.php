<?php

namespace App\Filament\Resources\RegistrationResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
                // Tables\Actions\CreateAction::make(),
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

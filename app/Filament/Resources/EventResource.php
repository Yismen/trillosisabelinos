<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\EventStatusEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers\PlansRelationManager;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->required()
                    ->minLength(3)
                    ->maxLength(500)
                    ->unique(ignoreRecord: true),
                DatePicker::make('date')
                    ->minDate(now()->startOfDay())
                    ->required()
                    ->closeOnDateSelection()
                    ->afterOrEqual(now()->startOfDay()),
                Select::make('currency')
                    ->options(config('app.trillos.currencies')),
                TagsInput::make('features')
                    ->required()
                    ->suggestions(config('app.trillos.features')),
                MarkdownEditor::make('description')
                    ->required(),
                FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->directory('events')
                    ->preserveFilenames()
                    ->maxSize(2000)
                    ->enableReordering()
                    ->enableOpen()
                    ->enableDownload(),
                Select::make('status')
                    ->options(EventStatusEnum::toArray())
                    ->nullable()
                    ->enum(EventStatusEnum::class)
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('currency')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TagsColumn::make('features')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->enum(EventStatusEnum::toArray())
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('name')
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
            'index' => Pages\ManageEvents::route('/'),
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
            PlansRelationManager::class,
        ];
    }
}

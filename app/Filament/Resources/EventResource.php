<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\EventStatusEnum;
use Illuminate\Validation\Rule;
use Filament\Resources\Resource;
use Filament\Tables\Columns\Column;
use Filament\Forms\Components\Select;
use Illuminate\Validation\Rules\Enum;
use App\Rules\Dates\AfterOrEqualToday;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers;

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
                    ->maxLength(500),
                DatePicker::make('date')
                    ->minDate(now()->startOfDay())
                    ->required()
                    ->afterOrEqual(now()->startOfDay())
                    ,
                Forms\Components\Select::make('currency')
                    ->options(config('app.trillos.currencies')),
                Forms\Components\TagsInput::make('features')
                    ->required()
                    ->suggestions(config('app.trillos.features')),
                Textarea::make('description')
                    ->required()
                    ,
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
                    ->disabled()
                    ,
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
}

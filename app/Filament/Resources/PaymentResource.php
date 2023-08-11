<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\Sale;
use Filament\Tables;
use App\Models\Payment;
use App\Models\Registration;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\PaymentResource\RelationManagers\SalesRelationManager;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Event Results';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Forms\Components\Select::make('registration_id')
                        ->searchable()
                        ->preload()
                        ->reactive()
                        ->disabledOn(['edit'])
                        ->options(function ($context, $record) {
                            return Registration::query()
                                ->when(
                                    in_array($context, ['edit']),
                                    fn ($query) => $query
                                        ->where('amount_pending', '>', 0)
                                        ->orWhere('id', '=', $record->registration->id)
                                )
                                ->when(
                                    in_array($context, ['create']),
                                    fn ($query) => $query
                                        ->where('amount_pending', '>', 0)
                                )
                                ->orderBy('name')
                                ->get()
                                ->map(fn ($registration) => [
                                    'id' => $registration->id,
                                    'name'  =>  "{$registration->name} - {$registration->amount_pending}"
                                ])
                                ->pluck('name', 'id');;
                        })
                        ->required()
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('amount', 0);
                            $set('sales', []);
                        }),
                    Forms\Components\DatePicker::make('date')
                        ->required()
                        ->closeOnDateSelection()
                        ->maxDate(now()->endOfDay()),
                    CheckboxList::make('sales')
                        ->options(function (Closure $get) {
                            $sales = Sale::query()
                                ->where('registration_id', $get('registration_id'))
                                ->where('payment_id', null)
                                ->get()
                                ->map(function ($sale) {
                                    return ['id' => $sale->id, 'name' => "{$sale->count} - {$sale->plan->name} - {$sale->amount}"];
                                })->pluck('name', 'id');

                            return $sales;
                        })
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('sales', $state);
                            $amount = Sale::query()->whereIn('id', $state)->sum('amount');

                            $set('amount', $amount / 100);
                        })
                        ->reactive()
                        ->required()
                        ->afterStateHydrated(function (CheckboxList $component, $state) {
                            // dd($component, $state);
                        })
                        ->hiddenOn(['edit']),
                    Forms\Components\TextInput::make('amount')
                        ->disabled(),
                    Forms\Components\Textarea::make('description')
                        ->nullable(),

                    Forms\Components\TextInput::make('code')
                        ->visibleOn(['view', 'edit'])
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
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Grid::make([
                    'sm' => 1
                ])
                    ->schema([
                        Stack::make([
                            TextColumn::make('registration.name')
                                ->getStateUsing(fn ($record) => "Registration: " . str($record->registration->name ?? '')->headline())
                                ->searchable()
                                ->sortable(),
                            TextColumn::make('date')
                                ->getStateUsing(fn ($record) => "Date: " . $record->date->format("M, d-Y"))
                                ->searchable()
                                ->sortable(),
                            TextColumn::make('code')
                                ->getStateUsing(fn ($record) => "Code: " . $record->code)
                                ->searchable()
                                ->sortable(),
                            TextColumn::make('amount')
                                ->getStateUsing(fn ($record) => "Amount: " . $record->amount),
                            TagsColumn::make('subscriptions'),
                        ]),
                    ])
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
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                // Tables\Actions\ForceDeleteAction::make(),
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
            'index' => Pages\ManagePayments::route('/'),
            // 'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
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
            SalesRelationManager::class
        ];
    }
}

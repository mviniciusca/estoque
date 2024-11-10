<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Product;
use App\Models\Report;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationGroup = 'Análise & Dados';

    protected static ?string $navigationLabel = 'Relatórios';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label(__('Produto'))
                    ->required()
                    ->disabled()
                    ->options(Product::pluck('name', 'id')),
                Forms\Components\TextInput::make('minimus')
                    ->required()
                    ->label(__('Quantidade Mínima'))
                    ->numeric()
                    ->default(3),
                Forms\Components\TextInput::make('maxims')
                    ->required()
                    ->label(__('Quantidade Máxima'))
                    ->numeric()
                    ->default(3),
                Forms\Components\Toggle::make('is_dispatch')
                    ->hidden()
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label(__('Produto'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('minimus')
                    ->label(__('Qte. Mínima'))
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maxims')
                    ->label(__('Qte. Máxima'))
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.stock.quantity')
                    ->label(__('Estoque'))
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_dispatched')
                    ->alignEnd()
                    ->label(__('Situação'))
                    ->default(function ($record) {
                        if ($record->product->stock->quantity == 0) {
                            return 'sem estoque';
                        } elseif ($record->product->stock->quantity <= $record->minimus) {
                            return 'baixo estoque';
                        } elseif ($record->product->stock->quantity > $record->maxims) {
                            return 'excesso de estoque';
                        } else {
                            return 'em estoque';
                        }
                    })
                    ->color(function ($record) {
                        if ($record->product->stock->quantity == 0) {
                            return 'danger';
                        } elseif ($record->product->stock->quantity <= $record->minimus) {
                            return 'warning';
                        } elseif ($record->product->stock->quantity > $record->maxims) {
                            return 'info';
                        } else {
                            return 'success';
                        }
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function checkStock(Get $get, Set $set, $state)
    {
        $qte = 5;
        $stock = $get('stock.quantity');

        dd($qte);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit'   => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}

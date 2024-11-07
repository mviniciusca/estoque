<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'E-Commerce';

    protected static ?string $navigationLabel = 'Produtos';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Product'))
                    ->columns(6)
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('Status'))
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->label(__('Produto'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('category_id')
                            ->label(__('Categoria'))
                            ->options(Category::pluck('name', 'id'))
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading(__('Produtos'))
            ->description(__('Listagem dos seus produtos no sistema!'))
            ->columns([
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Status'))
                    ->alignCenter()
                    ->boolean(),
                Tables\Columns\TextColumn::make('stock.quantity')
                    ->label(__('Estoque'))
                    ->alignCenter()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Produto'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->searchable()
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('Categoria'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.section')
                    ->label(__('Seção / Gaiola'))
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.geocode')
                    ->label(__('Geolocalização'))
                    ->numeric()
                    ->sortable(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

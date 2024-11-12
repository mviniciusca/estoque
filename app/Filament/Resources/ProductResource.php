<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'E-Commerce';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(6)
            ->schema([
                Group::make()
                    ->columnSpan(4)
                    ->schema([
                        Section::make(__('Produto'))
                            ->description(__('Informações sobre o seu produto.'))
                            ->icon('heroicon-o-shopping-bag')
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->prefixIcon('heroicon-o-shopping-bag')
                                    ->label(__('Produto'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('price')
                                    ->label(__('Preço'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('R$'),
                                Forms\Components\TextInput::make('sku')
                                    ->label('SKU')
                                    ->prefixIcon('heroicon-o-key')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make('description')
                                    ->label(__('Descrição'))
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('category_id')
                                    ->label(__('Categoria'))
                                    ->prefixIcon('heroicon-o-tag')
                                    ->columnSpanFull()
                                    ->options(Category::pluck('name', 'id'))
                                    ->required(),
                                Forms\Components\Toggle::make('is_active')
                                    ->label(__('Ativo'))
                                    ->default(true)
                                    ->required(),
                            ]),
                    ]),
                Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label(__('Imagem do Produto'))
                            ->image(),
                        Section::make(__('Estoque'))
                            ->icon('heroicon-o-cube')
                            ->description('Informações de estoque e controle de produto.')
                            ->schema([
                                Group::make()
                                    ->relationship('stock')
                                    ->schema([
                                        Forms\Components\TextInput::make('quantity')
                                            ->label('Estoque Disponível')
                                            ->suffix('un.')
                                            ->prefixIcon('heroicon-o-cube')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                                Group::make()
                                    ->relationship('report')
                                    ->schema([
                                        Forms\Components\TextInput::make('minimus')
                                            ->label('Estoque Mínimo')
                                            ->suffix('un.')
                                            ->prefixIcon('heroicon-o-cube')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('maxims')
                                            ->label('Estoque Máximo')
                                            ->suffix('un.')
                                            ->prefixIcon('heroicon-o-cube')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                            ]),
                        Section::make(__('Localização Setorial'))
                            ->icon('heroicon-o-map-pin')
                            ->description(__('Mapeamento Logístico do Produto'))
                            ->schema([]),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock.quantity')
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
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

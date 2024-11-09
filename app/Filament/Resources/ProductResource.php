<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

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
                            ->columns(2)
                            ->icon('heroicon-o-shopping-bag')
                            ->description(__('Crie o seu produto.'))
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('Nome do Produto'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('price')
                                    ->label(__('Preço'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('R$'),
                                TextInput::make('sku')
                                    ->label('SKU')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('category_id')
                                    ->label(__('Categoria'))
                                    ->options(Category::pluck('name', 'id'))
                                    ->required(),
                                RichEditor::make('description')
                                    ->label(__('Descrição'))
                                    ->columnSpanFull(),
                                Toggle::make('is_active')
                                    ->default(true)
                                    ->label(__('Ativo'))
                                    ->required(),
                            ]),
                    ]),
                Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make(__('Imagem'))
                            ->columnSpan(2)
                            ->columns(1)
                            ->icon('heroicon-o-photo')
                            ->description(__('Imagem do produto.'))
                            ->schema([
                                FileUpload::make('image')
                                    ->label(__('Imagem do Produto'))
                                    ->image(),
                            ]),
                        Section::make(__('Estoque'))
                            ->columnSpan(2)
                            ->columns(1)
                            ->icon('heroicon-o-cube')
                            ->description(__('Controle de estoque.'))
                            ->schema([
                                Group::make()
                                    ->relationship('stock')
                                    ->schema([
                                        TextInput::make('quantity')
                                            ->required()
                                            ->label(__('Quantidade em Estoque'))
                                            ->numeric()
                                            ->suffix('unidades')
                                            ->maxLength(255),
                                        TextInput::make('product_id')
                                            ->hidden()
                                            ->default(Product::latest('id')->value('id') + 1)
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('is_dispatched')
                    ->alignLeft()
                    ->label(__('Situação'))
                    ->default(function ($record) {
                        return self::checkStock($record, false);
                    })
                    ->color(function ($record) {
                        return self::checkStock($record, true);
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock.quantity')
                    ->label('Estoque')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
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

    /**
     * Summary of checkStock
     * @param mixed $record
     * @param bool $isColor
     * @return string
     */
    public static function checkStock($record, bool $isColor): string
    {
        if ($record->stock->quantity == 0) {
            return $isColor ? 'danger' : 'sem estoque';
        } elseif ($record->stock->quantity <= $record->stock->report->minimus) {
            return $isColor ? 'warning' : 'baixo estoque';
        } elseif ($record->stock->quantity > $record->stock->report->maxims) {
            return $isColor ? 'info' : 'excesso de estoque';
        } else {
            return $isColor ? 'success' : 'em estoque';
        }
    }
}

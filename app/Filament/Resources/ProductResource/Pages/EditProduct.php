<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Group::make()
                    ->relationship('stock')
                    ->schema([
                        TextInput::make('quantity')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('product_id')
                            ->hidden()
                            ->required()
                            ->maxLength(255),
                    ]),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                FileUpload::make('image')
                    ->image(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('sku')
                    ->label('SKU')
                    ->required()
                    ->maxLength(255),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

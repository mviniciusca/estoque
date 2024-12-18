<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected ?string $heading = 'Produtos';

    //protected ?string $subheading = 'Listagem dos seus produtos.';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__('Novo Produto'))->icon('heroicon-o-shopping-bag'),
        ];
    }
}

<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
    {
        // Criar o Stock
        $stock = $this->record->stock()->create([
            'product_id' => $this->record->id,
            // 'quantity'   => $this->data['stock.quantity'],
        ]);

        // // Criar o Report
        $this->record->report()->create([
            'product_id' => $this->record->id,
            'stock_id'   => $stock->id,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remover os campos temporários que usamos para o Stock e Report
        unset(
            $data['stock_quantity'],
            $data['report_minimus'],
            $data['report_maxims']
        );

        return $data;
    }
}

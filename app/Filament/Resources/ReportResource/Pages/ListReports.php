<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected static ?string $title = 'Relatórios';

    protected function getHeaderActions(): array
    {
        return [
            //  Actions\CreateAction::make()->icon('heroicon-o-document')->label(__('Novo Relatório')),
        ];
    }
}

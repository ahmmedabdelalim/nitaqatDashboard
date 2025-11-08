<?php

namespace App\Filament\Resources\UserLogsSummaries\Pages;

use App\Filament\Resources\UserLogsSummaries\UserLogsSummaryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserLogsSummaries extends ListRecords
{
    protected static string $resource = UserLogsSummaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}

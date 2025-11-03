<?php

namespace App\Filament\Resources\UnActiveUsers\Pages;

use App\Filament\Resources\UnActiveUsers\UnActiveUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUnActiveUsers extends ListRecords
{
    protected static string $resource = UnActiveUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

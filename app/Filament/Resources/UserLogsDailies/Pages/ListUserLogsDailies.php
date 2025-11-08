<?php

namespace App\Filament\Resources\UserLogsDailies\Pages;

use App\Filament\Resources\UserLogsDailies\UserLogsDailyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserLogsDailies extends ListRecords
{
    protected static string $resource = UserLogsDailyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\UserLogsMonthelies\Pages;

use App\Filament\Resources\UserLogsMonthelies\UserLogsMonthelyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserLogsMonthelies extends ListRecords
{
    protected static string $resource = UserLogsMonthelyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}

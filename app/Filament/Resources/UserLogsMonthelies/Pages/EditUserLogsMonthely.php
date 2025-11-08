<?php

namespace App\Filament\Resources\UserLogsMonthelies\Pages;

use App\Filament\Resources\UserLogsMonthelies\UserLogsMonthelyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserLogsMonthely extends EditRecord
{
    protected static string $resource = UserLogsMonthelyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

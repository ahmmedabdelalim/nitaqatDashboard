<?php

namespace App\Filament\Resources\UserLogsDailies\Pages;

use App\Filament\Resources\UserLogsDailies\UserLogsDailyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserLogsDaily extends EditRecord
{
    protected static string $resource = UserLogsDailyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

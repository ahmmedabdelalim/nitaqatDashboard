<?php

namespace App\Filament\Resources\UserLogsSummaries\Pages;

use App\Filament\Resources\UserLogsSummaries\UserLogsSummaryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserLogsSummary extends EditRecord
{
    protected static string $resource = UserLogsSummaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

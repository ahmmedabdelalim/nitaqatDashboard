<?php

namespace App\Filament\Resources\UnActiveUsers\Pages;

use App\Filament\Resources\UnActiveUsers\UnActiveUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUnActiveUser extends EditRecord
{
    protected static string $resource = UnActiveUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

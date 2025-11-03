<?php

namespace App\Filament\Resources\UnActiveUsers\Pages;

use App\Filament\Resources\UnActiveUsers\UnActiveUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUnActiveUser extends CreateRecord
{
    protected static string $resource = UnActiveUserResource::class;
}

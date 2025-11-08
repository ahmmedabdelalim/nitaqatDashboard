<?php

namespace App\Filament\Resources\UserLogsDailies;

use App\Filament\Resources\UserLogsDailies\Pages\CreateUserLogsDaily;
use App\Filament\Resources\UserLogsDailies\Pages\EditUserLogsDaily;
use App\Filament\Resources\UserLogsDailies\Pages\ListUserLogsDailies;
use App\Filament\Resources\UserLogsDailies\Schemas\UserLogsDailyForm;
use App\Filament\Resources\UserLogsDailies\Tables\UserLogsDailiesTable;
use App\Models\UserDailyActivity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use UnitEnum;

class UserLogsDailyResource extends Resource
{
    protected static ?string $model = UserDailyActivity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static UnitEnum|string|null $navigationGroup = 'Logs';

    protected static ?string $navigationLabel = 'User Log Daily';

    protected static ?string $pluralLabel = 'User Log Daily';

    protected static ?string $recordTitleAttribute = 'User Log Daily';

    public static function form(Schema $schema): Schema
    {
        return UserLogsDailyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserLogsDailiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserLogsDailies::route('/'),
            // 'create' => CreateUserLogsDaily::route('/create'),
            // 'edit' => EditUserLogsDaily::route('/{record}/edit'),
        ];
    }
}

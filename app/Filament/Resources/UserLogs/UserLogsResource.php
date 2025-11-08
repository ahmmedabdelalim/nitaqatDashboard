<?php

namespace App\Filament\Resources\UserLogs;

use App\Filament\Resources\UserLogs\Pages\CreateUserLogs;
use App\Filament\Resources\UserLogs\Pages\EditUserLogs;
use App\Filament\Resources\UserLogs\Pages\ListUserLogs;
use App\Filament\Resources\UserLogs\Pages\ViewUserLogs;
use App\Filament\Resources\UserLogs\Schemas\UserLogsForm;
use App\Filament\Resources\UserLogs\Schemas\UserLogsInfolist;
use App\Filament\Resources\UserLogs\Tables\UserLogsTable;
use App\Models\UserLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;
class UserLogsResource extends Resource
{
    protected static ?string $model = UserLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'Logs';

    protected static ?string $navigationLabel = 'User Logs';
    protected static ?string $recordTitleAttribute = 'User Logs';

    // public static function form(Schema $schema): Schema
    // {
    //     return UserLogsForm::configure($schema);
    // }

    public static function infolist(Schema $schema): Schema
    {
        return UserLogsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserLogsTable::configure($table);
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
            'index' => ListUserLogs::route('/'),
            // 'create' => CreateUserLogs::route('/create'),
            // 'view' => ViewUserLogs::route('/{record}'),
            // 'edit' => EditUserLogs::route('/{record}/edit'),
        ];
    }
}

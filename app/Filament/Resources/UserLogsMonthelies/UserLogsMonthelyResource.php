<?php

namespace App\Filament\Resources\UserLogsMonthelies;

use App\Filament\Resources\UserLogsMonthelies\Pages\CreateUserLogsMonthely;
use App\Filament\Resources\UserLogsMonthelies\Pages\EditUserLogsMonthely;
use App\Filament\Resources\UserLogsMonthelies\Pages\ListUserLogsMonthelies;
use App\Filament\Resources\UserLogsMonthelies\Schemas\UserLogsMonthelyForm;
use App\Filament\Resources\UserLogsMonthelies\Tables\UserLogsMontheliesTable;
use App\Models\UserMonthelyActivity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserLogsMonthelyResource extends Resource
{
    protected static ?string $model = UserMonthelyActivity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'Logs';
    protected static ?string $navigationLabel = 'User Logs Monthely';
    protected static ?string $pluralLabel = 'User Logs Monthely';

    protected static ?string $recordTitleAttribute = 'User Logs Monthely';

    public static function form(Schema $schema): Schema
    {
        return UserLogsMonthelyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserLogsMontheliesTable::configure($table);
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
            'index' => ListUserLogsMonthelies::route('/'),
            // 'create' => CreateUserLogsMonthely::route('/create'),
            // 'edit' => EditUserLogsMonthely::route('/{record}/edit'),
        ];
    }
}

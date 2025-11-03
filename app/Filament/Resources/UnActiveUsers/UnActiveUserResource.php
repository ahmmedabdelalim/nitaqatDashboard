<?php

namespace App\Filament\Resources\UnActiveUsers;

use App\Filament\Resources\UnActiveUsers\Pages\CreateUnActiveUser;
use App\Filament\Resources\UnActiveUsers\Pages\EditUnActiveUser;
use App\Filament\Resources\UnActiveUsers\Pages\ListUnActiveUsers;
use App\Filament\Resources\UnActiveUsers\Schemas\UnActiveUserForm;
use App\Filament\Resources\UnActiveUsers\Tables\UnActiveUsersTable;
use App\Models\UnActiveUser;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use UnitEnum; // ✅ Required for v4 typing


class UnActiveUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static UnitEnum|string|null $navigationGroup = 'Users';
    protected static ?string $navigationLabel = 'Un Active Users';


    protected static ?string $recordTitleAttribute = 'Un Active Users';

    public static function form(Schema $schema): Schema
    {
        return UnActiveUserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnActiveUsersTable::configure($table);
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
            'index' => ListUnActiveUsers::route('/'),
            'create' => CreateUnActiveUser::route('/create'),
            'edit' => EditUnActiveUser::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('active', 0);
    }

}

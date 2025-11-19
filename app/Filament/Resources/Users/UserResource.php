<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum; // ✅ Required for v4 typing

class UserResource extends Resource
{
    protected static ?string $model = User::class;
 
    // ✅ Correct type for v4
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // ✅ Fix: must allow UnitEnum|string|null
    protected static UnitEnum|string|null $navigationGroup = 'Users';

    protected static ?string $navigationLabel = 'Active Users';

    protected static ?string $recordTitleAttribute = 'User Permission';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    // ✅ Show only active users
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('active', 1);
    }
}

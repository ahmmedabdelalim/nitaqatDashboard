<?php

namespace App\Filament\Resources\UserLogsSummaries;

use App\Filament\Resources\UserLogsSummaries\Pages\CreateUserLogsSummary;
use App\Filament\Resources\UserLogsSummaries\Pages\EditUserLogsSummary;
use App\Filament\Resources\UserLogsSummaries\Pages\ListUserLogsSummaries;
use App\Filament\Resources\UserLogsSummaries\Schemas\UserLogsSummaryForm;
use App\Filament\Resources\UserLogsSummaries\Tables\UserLogsSummariesTable;
use App\Models\UserSummaryActivity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;
class UserLogsSummaryResource extends Resource
{
    protected static ?string $model = UserSummaryActivity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'Logs';

    protected static ?string $navigationLabel = 'User Logs Summary';
    protected static ?string $pluralLabel = 'User Logs Summary';

    protected static ?string $recordTitleAttribute = 'User Logs Summary';

    public static function form(Schema $schema): Schema
    {
        return UserLogsSummaryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserLogsSummariesTable::configure($table);
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
            'index' => ListUserLogsSummaries::route('/'),
            // 'create' => CreateUserLogsSummary::route('/create'),
            // 'edit' => EditUserLogsSummary::route('/{record}/edit'),
        ];
    }
}

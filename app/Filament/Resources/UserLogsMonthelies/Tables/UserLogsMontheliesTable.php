<?php

namespace App\Filament\Resources\UserLogsMonthelies\Tables;

use DateTime;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Date;

class UserLogsMontheliesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //

                TextColumn::make('id')->label('ID')->sortable()->searchable(),
                TextColumn::make('user_id')->label('User ID')->sortable()->searchable(),
                TextColumn::make('username')->label('Username')->sortable()->searchable(),
                TextColumn::make('month')->label('Month')->sortable()->searchable(),
                TextColumn::make('total_active_seconds')->label('Total Active Time')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

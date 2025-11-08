<?php

namespace App\Filament\Resources\UserLogsDailies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserLogsDailiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id')->label('ID'),
                TextColumn::make('user_id')->label('User ID')->sortable() ->searchable(),
                TextColumn::make('username')->label('User Name')->searchable(),
                TextColumn::make('activity_date')->label('Activity Date')->sortable()->searchable(),
                TextColumn::make('total_active_seconds')->label('Total Active Time (min)')->sortable()->searchable(),
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

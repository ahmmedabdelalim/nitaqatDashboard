<?php

namespace App\Filament\Resources\UserLogsSummaries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserLogsSummariesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //

                TextColumn::make('id')->sortable(),
                TextColumn::make('user_id')->label('User Id')->sortable(),
                TextColumn::make('username')->searchable(),
                TextColumn::make('total_active_seconds')->label('Total Active Time (min)')->searchable(),
                TextColumn::make('upload_count')->label('Total upload time')->searchable(),
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

<?php

namespace App\Filament\Resources\UserLogs\Tables;

use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id')->sortable(),
                TextColumn::make('user_id')->label('User Id')->sortable(),
                TextColumn::make('username')->searchable(),
                TextColumn::make('action')->searchable(),
                TextColumn::make('timestamp_date')
                ->label('Date')
                ->getStateUsing(fn ($record) => Carbon::parse($record->timestamp)->format('Y-m-d')),

            TextColumn::make('timestamp_time')
                ->label('Time')
                ->getStateUsing(fn ($record) => Carbon::parse($record->timestamp)->format('H:i:s')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
              //  ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

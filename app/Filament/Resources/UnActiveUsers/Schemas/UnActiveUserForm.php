<?php

namespace App\Filament\Resources\UnActiveUsers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UnActiveUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),

            
            Select::make('role')
                ->label('Role')
                ->options([
                    'user' => 'User',
                    'admin' => 'Admin',
                ])
                ->default('user')
                ->required(),

            Toggle::make('active')
                ->label('Active')
                ->default(true),

            Toggle::make('calc')
                ->label('Calc Access')
                ->default(false),

            Toggle::make('reports')
                ->label('Reports Access')
                ->default(false),

            Toggle::make('upload')
                ->label('Upload Access')
                ->default(false),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
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

            // TextInput::make('password')
            //     ->label('Password')
            //     ->password()
            //     ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
            //     ->required(fn (string $context): bool => $context === 'create')
            //     ->maxLength(255),

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
            Toggle::make('saudization_percentage')
                ->label('Saudization Percentage Access')
                ->default(false),

            ]);
    }
}

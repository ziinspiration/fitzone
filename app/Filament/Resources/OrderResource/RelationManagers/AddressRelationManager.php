<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->required()
                    ->tel()
                    ->maxLength(20),

                TextInput::make('street_address')
                    ->required()
                    ->maxLength(255),

                TextInput::make('district')
                    ->required()
                    ->maxLength(255),

                TextInput::make('city_id')
                    ->required()
                    ->maxLength(10),

                TextInput::make('province_id')
                    ->required()
                    ->maxLength(10),

                TextInput::make('postal_code')
                    ->required()
                    ->maxLength(10),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('street_address')
            ->columns([
                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->getStateUsing(fn($record) => $record->full_name ?? 'No Name'),

                TextColumn::make('phone'),

                TextColumn::make('street_address')
                    ->label('Street Address'),

                TextColumn::make('district')
                    ->label('District'),

                TextColumn::make('city_name')
                    ->label('City'),

                TextColumn::make('province_name')
                    ->label('Province'),

                TextColumn::make('postal_code')
                    ->label('Postal Code'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
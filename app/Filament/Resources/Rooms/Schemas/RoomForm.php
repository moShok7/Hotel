<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MultiSelect;
class RoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('poster_url')
    ->label('Логотип')
    ->image()
    ->disk('public')
    ->directory('rooms/posters')
    ->imagePreviewHeight('150')
    ->columnSpanFull(),
                TextInput::make('floor_area')
                    ->required()
                    ->numeric(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
               Select::make('hotel_id')
    ->label('Отель')
    ->relationship('hotel', 'title')
    ->searchable()
    ->preload()
    ->required(),
  MultiSelect::make('facilities')
    ->label('Удобства')
    ->relationship('facilities', 'title')
    ->searchable()
    ->preload()
    ->createOptionForm([
        TextInput::make('title')->required(),
    ]),
            ]);
    }
}

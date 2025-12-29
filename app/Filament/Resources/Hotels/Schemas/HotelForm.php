<?php

namespace App\Filament\Resources\Hotels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MultiSelect;
class HotelForm
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
    ->directory('hotels/posters')
    ->imagePreviewHeight('150')
    ->columnSpanFull(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
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

<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('question')
                                    ->label('Question')
                                    ->columnSpanFull(),
                                TextEntry::make('category.name')
                                    ->label('Category'),
                                TextEntry::make('id')
                                    ->label('ID'),
                                TextEntry::make('created_at')
                                    ->label('Created')
                                    ->badge()
                                    ->dateTime(),
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ])
                            ->columns([
                                'default' => 1,
                                'sm' => 2,
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('Content')
                    ->schema([
                        TextEntry::make('answer')
                            ->label('Answer')
                            ->html()
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}

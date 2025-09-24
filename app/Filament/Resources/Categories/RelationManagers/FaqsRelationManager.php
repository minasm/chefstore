<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Faqs\FaqResource;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqsRelationManager extends RelationManager
{
    protected static string $relationship = 'faqs';

    protected static ?string $relatedResource = CategoryResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('FAQs'))
            ->modelLabel(__('FAQ'))
            ->pluralModelLabel(__('FAQs'))
            ->columns([
                TextColumn::make('question')
                    ->label('Question')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('answer')
                    ->label('Answer')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn ($record) => FaqResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
                EditAction::make()
                    ->url(fn ($record) => FaqResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

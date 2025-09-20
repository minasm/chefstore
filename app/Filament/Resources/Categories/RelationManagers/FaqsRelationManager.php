<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class FaqsRelationManager extends RelationManager
{
    protected static string $relationship = 'faqs';

    protected static ?string $relatedResource = CategoryResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

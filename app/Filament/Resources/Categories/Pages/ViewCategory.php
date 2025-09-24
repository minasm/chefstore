<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('faqs')
                ->label('FAQs')
                ->icon('heroicon-m-question-mark-circle')
                ->url(fn () => $this->getResource()::getUrl('view', [
                    'record' => $this->record,
                    'relation' => 'faqs',
                ]))
                ->color('gray'),
        ];
    }
}

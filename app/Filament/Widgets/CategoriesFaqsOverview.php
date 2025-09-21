<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Faq;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CategoriesFaqsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Categories', (string) Category::count())
                ->description('Total categories in the knowledge base')
                ->icon('heroicon-o-rectangle-stack'),
            Stat::make('FAQs', (string) Faq::count())
                ->description('Articles available for customers')
                ->icon('heroicon-o-question-mark-circle'),
        ];
    }
}

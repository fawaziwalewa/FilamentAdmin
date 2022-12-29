<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ProductStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Products', '50'),
            Card::make('Product Inventory', '264'),
            Card::make('Average price', '224.71')
        ];
    }
}

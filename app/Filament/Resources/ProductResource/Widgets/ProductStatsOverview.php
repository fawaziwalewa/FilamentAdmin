<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ProductStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Products', Product::count()),
            Card::make('Product Inventory', Product::sum('quantity')),
            Card::make('Average price', Product::avg('price')),
        ];
    }
}

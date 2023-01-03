<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class OrderStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Orders', 22)->chart([7, 2, 10, 3, 15, 4, 17]),
            Card::make('Open orders', 676),
            Card::make('Average price', 22),
        ];
    }
}

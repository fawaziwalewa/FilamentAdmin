<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Revenue', '192.1k')
                ->description('32k increase')
                 ->chart([7, 2, 10, 3, 15, 4, 17])
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('New customers', '1340')
                ->description('3% decrease')
                 ->chart([7, 6, 3, 3, 2, 1, 0])
                ->descriptionIcon('heroicon-s-trending-down')
                ->color('danger'),
            Card::make('New orders', '3543')
                ->description('7% increase')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}

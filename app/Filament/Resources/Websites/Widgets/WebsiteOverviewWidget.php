<?php

namespace App\Filament\Resources\Websites\Widgets;

use App\Models\Website;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WebsiteOverviewWidget extends StatsOverviewWidget
{
    public ?Website $record = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Unique visits', $this->record->getUniqueVisitsCount()),
            Stat::make('Views', $this->record->getViewsCount()),
            Stat::make('Bounce rate', sprintf('%s%%', $this->record->getBounceRate() * 100)),
            Stat::make('Average time on page', $this->record->getAverageTimeOnPage()),
        ];
    }
}

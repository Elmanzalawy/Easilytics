<?php

namespace App\Filament\Resources\Websites\Pages;

use App\Filament\Resources\Websites\WebsiteResource;
use App\Filament\Resources\Websites\Widgets\PageViewsWidget;
use App\Filament\Resources\Websites\Widgets\WebsiteOverviewWidget;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWebsite extends ViewRecord
{
    protected static string $resource = WebsiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        // return [
        //     WebsiteOverviewWidget::class,
        // ];

        return [
            WebsiteOverviewWidget::make(),
            PageViewsWidget::make(),
        ];
    }
}

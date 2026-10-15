<?php

namespace App\Filament\Resources\Websites\Pages;

use App\Filament\Resources\Websites\WebsiteResource;
use App\Filament\Resources\Websites\Widgets\EnvironmentWidget;
use App\Filament\Resources\Websites\Widgets\LocationWidget;
use App\Filament\Resources\Websites\Widgets\PageViewsWidget;
use App\Filament\Resources\Websites\Widgets\ReferrersWidget;
use App\Filament\Resources\Websites\Widgets\WebsiteOverviewWidget;
use App\Services\AnalyticsScriptService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWebsite extends ViewRecord
{
    protected static string $resource = WebsiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('integrationScript')
                ->label('Integration script')
                ->icon('heroicon-o-code-bracket')
                ->modalHeading('Add this to the <head> of your website')
                ->modalDescription(fn (): string => app(AnalyticsScriptService::class)->snippet($this->getRecord()))
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Close'),
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
            ReferrersWidget::make(),
            // EnvironmentWidget::make(),
            // LocationWidget::make(),
        ];
    }
}

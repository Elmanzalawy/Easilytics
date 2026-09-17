<?php

namespace App\Filament\Resources\Websites\Widgets;

use App\Models\Website;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class PageViewsWidget extends TableWidget
{
    public ?Website $record = null;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => $this->record->query())
            ->modifyQueryUsing(function (Builder $query) {
                return $query->selectRaw('page_views.id, page_views.path, COUNT(*) as page_views_count')
                    ->join('page_views', 'page_views.website_id', '=', 'websites.id')
                    ->groupBy('page_views.path')
                    ->orderBy('page_views_count', 'desc');
            })
            ->columns([
                TextColumn::make('path'),
                TextColumn::make('page_views_count')->label('Page Views'),
            ])
            ->paginationPageOptions([5, 10, 25])
            ->defaultPaginationPageOption(5)
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}

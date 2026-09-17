<?php

namespace App\Filament\Resources\Websites\Widgets;

use App\Models\Website;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ReferrersWidget extends TableWidget
{
    public ?Website $record = null;

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => $this->record->visitorSessions()->getQuery())
            ->modifyQueryUsing(function (Builder $query) {
                return $query->selectRaw('visitor_sessions.id, visitor_sessions.referrer, COUNT(*) as referrers_count')
                    ->whereNotNull('visitor_sessions.referrer')
                    ->groupBy('visitor_sessions.referrer')
                    ->orderBy('referrers_count', 'desc');
            })
            ->columns([
                TextColumn::make('referrer'),
                TextColumn::make('referrers_count')->label('Total'),
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

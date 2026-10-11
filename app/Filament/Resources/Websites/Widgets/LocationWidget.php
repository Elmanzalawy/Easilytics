<?php

namespace App\Filament\Resources\Websites\Widgets;

use App\Models\Website;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LocationWidget extends TableWidget
{
    public ?Website $record = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => $this->record->visitorSessions()->getQuery())
            ->columns([
                //
            ])
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

<?php

namespace App\Filament\Resources\Websites\Widgets;

use App\Models\Website;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\FiltersResetActionPosition;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class EnvironmentWidget extends TableWidget
{
    use HasFiltersForm;

    private const ENVIRONMENT_COLUMNS = [
        'browser' => ['column' => 'browser', 'label' => 'Browser'],
        'os' => ['column' => 'os', 'label' => 'OS'],
        'device' => ['column' => 'device_type', 'label' => 'Device'],
    ];

    public ?Website $record = null;

    public string $selectedEnvironment = 'os';

    public function persistsFiltersInSession(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        $environmentColumn = self::ENVIRONMENT_COLUMNS[$this->selectedEnvironment] ?? self::ENVIRONMENT_COLUMNS['os'];

        return $table
            ->query(fn(): Builder => $this->record->visitorSessions()->getQuery())
            ->modifyQueryUsing(function (Builder $query) use ($environmentColumn) {
                return $query
                    ->selectRaw("visitor_sessions.id, visitor_sessions.{$environmentColumn['column']}, COUNT(*) as count")
                    ->groupBy("visitor_sessions.{$environmentColumn['column']}")
                    ->orderByDesc('count');
            })
            ->columns([
                TextColumn::make($environmentColumn['column'])->label($environmentColumn['label'] . rand(1, 1000)),
                TextColumn::make('count')->label('Visitors'),
            ])
            ->filters([

                Filter::make('environment_variable')
                    ->label('Environment Variable')
                    ->schema([
                        // ToggleButtons::make('environment_variable')
                        //     ->hiddenLabel()
                        //     ->live()
                        //     ->columnSpanFull()
                        //     ->inline()
                        //     ->afterStateUpdated(function (?string $state): void {
                        //         info($state);
                        //         $this->table->filtersApplyAction(fn() => null);
                        //         $this->afterEnvironmentChanged($state);
                        //     })
                        //     ->options([
                        //         'browser' => 'Browsers',
                        //         'os' => 'OS',
                        //         'device' => 'Devices',
                        //     ])
                        //     ->default('os'),
                        Select::make('environment_variable')
                            ->hiddenLabel()
                            ->live()
                            ->afterStateUpdated(function (?string $state): void {
                                info($state);
                                $this->table->filtersApplyAction(fn() => null);
                                $this->afterEnvironmentChanged($state);
                            })
                            ->options([
                                'browser' => 'Browsers',
                                'os' => 'OS',
                                'device' => 'Devices',
                            ])
                            ->default('os'),
                    ]),
            ], layout: FiltersLayout::AboveContent)
            // ->filtersResetActionPosition(FiltersResetActionPosition::Footer)
            // ->deferFilters(false) // <-- this is the key call
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

    private function afterEnvironmentChanged(?string $environment): void
    {
        if (array_key_exists($environment, self::ENVIRONMENT_COLUMNS)) {
            $this->selectedEnvironment = $environment;
            $this->dispatch('$refresh');
        }
    }
}

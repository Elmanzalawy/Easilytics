<?php

namespace App\Filament\Resources\Websites\Schemas;

use App\Models\Website;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WebsiteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('url'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Website $record): bool => $record->trashed()),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Websites\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WebsiteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('url')
                    ->url()
                    ->required(),
            ]);
    }
}

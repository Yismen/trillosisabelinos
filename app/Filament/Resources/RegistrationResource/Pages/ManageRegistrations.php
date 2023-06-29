<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Filament\Resources\RegistrationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRegistrations extends ManageRecords
{
    protected static string $resource = RegistrationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

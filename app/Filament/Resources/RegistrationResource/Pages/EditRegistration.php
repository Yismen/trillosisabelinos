<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\RegistrationResource;

class EditRegistration extends EditRecord
{
    protected static string $resource = RegistrationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

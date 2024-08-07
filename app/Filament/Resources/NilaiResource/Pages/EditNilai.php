<?php

namespace App\Filament\Resources\NilaiResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\NilaiResource;

class EditNilai extends EditRecord
{
    protected static string $resource = NilaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('create')
            ->disabled(function (): bool {
                return $this->data['nilai'] > 100 ?  true : false;
            });
    }
}

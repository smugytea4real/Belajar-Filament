<?php

namespace App\Filament\Resources\NilaiResource\Pages;

use App\Filament\Resources\NilaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNilais extends ListRecords
{
    protected static string $resource = NilaiResource::class;

    protected function getHeaderActions(): array
    {
        // $queryString = request()->getQueryString();
        $decodeQueryString = urldecode(request()->getQueryString());
        return [
            Actions\Action::make('export')
                ->url(url('/export?'.$decodeQueryString)),
            Actions\CreateAction::make(),
        ];
    }
}

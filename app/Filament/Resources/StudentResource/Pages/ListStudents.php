<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Actions;
use App\Models\Student;
use App\Imports\ImportStudents;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StudentResource;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View 
    {
        $data = Actions\CreateAction::make();
        return view('filament.custom.upload-file', compact('data'));
    }

    public $file = '';

    public function save() {
        if($this->file != '') {
            Excel::import(new ImportStudents, $this->file);
        }
    }

    public function getTabs(): array
{
    return [
        'all' => Tab::make(),
        'accept' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'accept')),
        'off' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'off')),
        'move' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'move')),
        'grade' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'grade')),
    ];
}
}
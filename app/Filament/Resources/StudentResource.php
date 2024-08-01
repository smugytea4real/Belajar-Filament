<?php

namespace App\Filament\Resources;

use Filament\Tables\Filters\SelectFilter;
use stdClass;
use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Notifications\Collection;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;


class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Academic';

    protected static ?int $navigationSort= 22;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nis')
                            ->label('NIS'),
                        TextInput::make('name')
                            ->label('Name Student')
                            ->required(),
                        Select::make('gender')
                            ->options([
                                "Male" => "Male",
                                "Female" => "Female",
                            ]),
                        DatePicker::make('birthday')
                            ->label('Birthday'),
                        Select::make('religion')
                            ->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu' => 'Hindu',
                                'Budha' => 'Budha',
                                'Konghucu' => 'Konghucu',
                            ])
                            ->label('Religion'),
                        TextInput::make('contact'),
                        FileUpload::make('profile')
                            ->directory('students')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('nis')
                    ->label('NIS'),
                TextColumn::make('name')
                    ->label('Name Student'),
                TextColumn::make('gender'),
                TextColumn::make('birthday')
                    ->label('Birthday')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('religion')
                    ->label('Religion')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('contact'),
                ImageColumn::make('profile'),
                TextColumn::make('status')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn (string $state): string => ucwords("{$state}"))
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options([
                        'accept' => 'Accept',
                        'off' => 'Off',
                        'move' => 'Move',
                        'grade' => 'Grade',
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                BulkAction::make('Change Status')
                    ->icon('heroicon-m-check')
                    ->requiresConfirmation()
                    ->form([
                        Select::make('status')
                            ->label('Status')
                            ->options(['accept' => 'Accept', 'off' => 'Off', 'move' => 'Move', 'grade' => 'Grade'])
                            ->required(),
                    ])
                    ->action(function ($records, array $data) { 
                        $records->each(function($record) use ($data) {
                        $record->update(['status' => $data['status']]);
                        });
                    }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            
            ])
            // ->headerActions([
            //     Tables\Actions\CreateAction::make(),
            // ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
            'view' => Pages\ViewStudent::route('/{record}'),
        ];
    }

    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();

        if ($locale == 'id') {
            return 'Murid';
        } else {
            return 'Student';
        }
    }

    public static function infolist(Infolist $infolist): Infolist
    {
    return $infolist
        ->schema([
            TextEntry::make('nis'),
            TextEntry::make('name'),
        ]);
    }
}

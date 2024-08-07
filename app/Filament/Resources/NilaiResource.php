<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Nilai;
use App\Models\Periode;
use App\Models\Student;
use App\Models\Subject;
use Filament\Forms\Form;
use App\Models\Classroom;
use Filament\Tables\Table;
use App\Models\CategoryNilai;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NilaiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NilaiResource\RelationManagers;

class NilaiResource extends Resource
{
    protected static ?string $model = Nilai::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Card::make()
                    ->schema([
                        Select::make('class_id')
                            ->options(Classroom::all()->pluck('name', 'id'))
                            ->label('Class'),
                        Select::make('periode_id')
                            ->options(Periode::all()->pluck('name', 'id'))
                            ->label('Periode')
                            ->searchable(),
                        Select::make('subject_id')
                            ->label('Subject')
                            ->searchable()
                            ->options(Subject::all()->pluck('name', 'id')),
                        Select::make('category_nilai_id')
                            ->label('Category Nilai')
                            ->searchable()
                            ->options(CategoryNilai::all()->pluck('name', 'id')),
                        Select::make('student_id')
                            ->label('Student')
                            ->options(Student::all()->pluck('name', 'id')),
                        TextInput::make('nilai')
                    ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name'),
                TextColumn::make('subject.name'),
                TextColumn::make('category_nilai.name'),
                TextColumn::make('nilai'),
                TextColumn::make('periode.name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListNilais::route('/'),
            'create' => Pages\CreateNilai::route('/create'),
            'edit' => Pages\EditNilai::route('/{record}/edit'),
        ];
    }
}

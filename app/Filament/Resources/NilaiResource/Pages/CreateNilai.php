<?php

namespace App\Filament\Resources\NilaiResource\Pages;

use App\Models\Nilai;
use Filament\Actions;
use App\Models\Periode;
use App\Models\Student;
use App\Models\Subject;
use Filament\Forms\Form;
use App\Models\Classroom;
use App\Models\CategoryNilai;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\NilaiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNilai extends CreateRecord
{
    protected static string $resource = NilaiResource::class;

    protected static string $view = 'filament.resources.nilai-resource.pages.form-nilai';

    public function form(Form $form): Form
    {
        return $form->schema([
            Card::make()
                ->schema([
                    Card::make()
                        ->schema([
                            Select::make('classrooms')
                                ->options(Classroom::all()->pluck('name', 'id'))
                                ->label('Class'),
                            Select::make('periode')
                                ->options(Periode::all()->pluck('name', 'id'))
                                ->label('Periode')
                                ->searchable(),
                            Select::make('subject_id')
                                ->label('Subject')
                                ->searchable()
                                ->options(Subject::all()->pluck('name', 'id')),
                            Select::make('category_nilai')
                                ->label('Category Nilai')
                                ->searchable()
                                ->options(CategoryNilai::all()->pluck('name', 'id'))
                                ->columnSpan(3),
                        ])->columns(3),

                    Repeater::make('nilaistudents')
                        ->label('Grade')
                        ->schema([
                            Select::make('student')
                                ->options(Student::all()->pluck('name', 'id'))
                                ->label('Student'),
                            TextInput::make('nilai')
                        ])->columns(2)
                ])
        ]);
    }

    public function save(){
        $get = $this->form->getState();

        $insert = [];
        foreach($get['nilaistudents'] as $row){
            array_push($insert, [
                'class_id' => $get['classrooms'],
                'periode_id' => $get['periode'],
                'subject_id' => $get['subject_id'],
                'category_nilai_id' => $get['category_nilai'],
                'student_id' => $row['student'],
                'nilai' => $row['nilai'],
                'teacher_id' => Auth::user()->id
            ]);
        }

        Nilai::insert($insert);

        return redirect()->to('admin/nilais');
    }
}

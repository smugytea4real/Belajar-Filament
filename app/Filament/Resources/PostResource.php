<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use stdClass;
use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                         Forms\Components\Builder::make('description')
                            ->blocks([
                                Forms\Components\Builder\Block::make('heading')
                                ->schema([
                                        Forms\Components\TextInput::make('content')
                                        ->label('Heading')
                                        ->required(),
                                        Forms\Components\Select::make('level')
                                        ->options([
                                            'h1' => 'Heading 1',
                                            'h2' => 'Heading 2',
                                            'h3' => 'Heading 3',
                                            'h4' => 'Heading 4',
                                            'h5' => 'Heading 5',
                                            'h6' => 'Heading 6',
                                        ])
                                        ->required(),
                                ])
                                ->columns(2),
                                Forms\Components\Builder\Block::make('paragraph')
                                ->schema([
                                        Forms\Components\RichEditor::make('content')
                                        ->label('Paragraph')
                                        ->required(),
                                ]),
                                Forms\Components\Builder\Block::make('image')
                                ->schema([
                                        Forms\Components\FileUpload::make('url')
                                        ->label('Image')
                                        ->directory('image_content')
                                        ->image()
                                        ->required(),
                                        Forms\Components\TextInput::make('alt')
                                        ->label('Alt text')
                                        ->required(),
                                    ]),
                            ])


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
                ImageColumn::make('url')
                    ->disk('image_content')  
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}

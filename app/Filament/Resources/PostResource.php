<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                //
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

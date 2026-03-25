<?php

namespace App\Filament\Resources;

use App\Domains\News\Models\News;
use App\Filament\Resources\NewsResource\Pages;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'News';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('newsDatum')
                ->label('Date')
                ->required(),

            TextInput::make('newsYear')
                ->label('Year')
                ->required(),

            RichEditor::make('newsText')
                ->label('Text')
                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList'])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('newsYear', 'desc')
            ->columns([
                TextColumn::make('newsYear')
                    ->label('Year')
                    ->sortable(),
                TextColumn::make('newsDatum')
                    ->label('Date'),
                TextColumn::make('newsText')
                    ->label('Text')
                    ->html()
                    ->limit(80),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit'   => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}

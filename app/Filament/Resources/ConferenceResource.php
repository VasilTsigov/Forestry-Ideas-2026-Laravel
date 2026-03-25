<?php

namespace App\Filament\Resources;

use App\Domains\Conference\Models\Conference;
use App\Filament\Resources\ConferenceResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConferenceResource extends Resource
{
    protected static ?string $model = Conference::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Conferences';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('confTitle')
                ->label('Title')
                ->required(),

            TextInput::make('confDate')
                ->label('Date')
                ->placeholder('e.g. 12–14 June 2024'),

            TextInput::make('confFileName')
                ->label('PDF File name')
                ->placeholder('e.g. conference2024.pdf'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('confDate', 'desc')
            ->columns([
                TextColumn::make('confDate')
                    ->label('Date')
                    ->sortable(),
                TextColumn::make('confTitle')
                    ->label('Title')
                    ->html()
                    ->limit(80),
                TextColumn::make('confFileName')
                    ->label('PDF')
                    ->default('—'),
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
            'index'  => Pages\ListConferences::route('/'),
            'create' => Pages\CreateConference::route('/create'),
            'edit'   => Pages\EditConference::route('/{record}/edit'),
        ];
    }
}

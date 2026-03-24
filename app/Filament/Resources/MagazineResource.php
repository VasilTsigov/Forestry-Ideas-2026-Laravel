<?php

namespace App\Filament\Resources;

use App\Domains\Magazine\Models\Magazine;
use App\Filament\Resources\MagazineResource\Pages;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MagazineResource extends Resource
{
    protected static ?string $model = Magazine::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Journals';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(4)->schema([
                TextInput::make('journalTitle')
                    ->label('Име')
                    ->columnSpan(1),
                TextInput::make('journalYear')
                    ->label('Година')
                    ->required()
                    ->columnSpan(1),
                TextInput::make('journalVolume')
                    ->label('Том')
                    ->required()
                    ->columnSpan(1),
                TextInput::make('journalNr')
                    ->label('Брой')
                    ->required()
                    ->columnSpan(1),
            ]),

            Grid::make(2)->schema([
                FileUpload::make('journalFile')
                    ->label('Journal PDF')
                    ->disk('journal')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(51200)
                    ->downloadable()
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file) => 'Forestry_Ideas_BG_' . $file->getClientOriginalName()
                    ),

                FileUpload::make('journalFileContent')
                    ->label('Table of Contents PDF')
                    ->disk('journal_content')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(20480)
                    ->downloadable()
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file) => 'JournalContent_cnt_' . $file->getClientOriginalName()
                    ),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('journalYear', 'desc')
            ->columns([
                TextColumn::make('journalYear')
                    ->label('Year')
                    ->sortable(),
                TextColumn::make('journalVolume')
                    ->label('Vol.')
                    ->sortable(),
                TextColumn::make('journalNr')
                    ->label('Nr.')
                    ->sortable(),
                TextColumn::make('journalTitle')
                    ->label('Title')
                    ->default('—'),
                TextColumn::make('articles_count')
                    ->label('Articles')
                    ->counts('articles')
                    ->sortable(),
                TextColumn::make('journalCount')
                    ->label('Downloads')
                    ->sortable(),
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
            'index'  => Pages\ListMagazines::route('/'),
            'create' => Pages\CreateMagazine::route('/create'),
            'edit'   => Pages\EditMagazine::route('/{record}/edit'),
        ];
    }
}

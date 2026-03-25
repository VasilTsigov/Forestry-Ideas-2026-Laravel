<?php

namespace App\Filament\Resources;

use App\Domains\Article\Models\Article;
use App\Domains\Magazine\Models\Magazine;
use App\Filament\Resources\ArticleResource\Pages;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Articles';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->columns(1)->schema([
            Select::make('issueJournalID')
                ->label('Journal')
                ->options(
                    Magazine::orderByDesc('journalYear')
                        ->orderByDesc('journalVolume')
                        ->orderByDesc('journalNr')
                        ->get()
                        ->mapWithKeys(fn ($m) => [
                            $m->journalID => "{$m->journalYear} Vol.{$m->journalVolume} Nr.{$m->journalNr}"
                                . ($m->journalTitle ? " — {$m->journalTitle}" : ''),
                        ])
                )
                ->required()
                ->searchable(),

            FileUpload::make('issueFile')
                ->label('File')
                ->disk('issue')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(20480)
                ->downloadable()
                ->getUploadedFileNameForStorageUsing(
                    fn (TemporaryUploadedFile $file) => 'Forestry_Ideas_BG_' . $file->getClientOriginalName()
                ),

            RichEditor::make('issueTitle')
                ->label('Title')
                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList']),

            RichEditor::make('issueAutor')
                ->label('Autor')
                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList']),

            RichEditor::make('issueFrom')
                ->label('From')
                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList']),

            RichEditor::make('issueSummary')
                ->label('Summary')
                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('issueID', 'desc')
            ->columns([
                TextColumn::make('magazine.journalYear')
                    ->label('Year')
                    ->sortable(),
                TextColumn::make('magazine.journalVolume')
                    ->label('Vol.')
                    ->sortable(),
                TextColumn::make('magazine.journalNr')
                    ->label('Nr.')
                    ->sortable(),
                TextColumn::make('issueTitle')
                    ->label('Title')
                    ->html()
                    ->limit(60),
                TextColumn::make('issueAutor')
                    ->label('Autor')
                    ->html()
                    ->limit(40),
                TextColumn::make('issueCount')
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
            'index'  => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit'   => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}

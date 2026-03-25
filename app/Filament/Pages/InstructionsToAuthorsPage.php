<?php

namespace App\Filament\Pages;

use App\Domains\Page\Models\InstructionToAuthors;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use FilamentTiptapEditor\TiptapEditor;

class InstructionsToAuthorsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Instructions to Authors';
    protected static ?string $title = 'Instructions to Authors';
    protected static ?string $navigationGroup = 'Pages';
    protected static ?int $navigationSort = 12;
    protected static string $view = 'filament.pages.content-page';

    public ?array $data = [];

    public function mount(): void
    {
        $record = InstructionToAuthors::firstOrCreate([]);
        $this->form->fill(['instrText' => $record->instrText]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TiptapEditor::make('instrText')->label('')->profile('default')->columnSpanFull(),
        ])->statePath('data');
    }

    public function save(): void
    {
        $record = InstructionToAuthors::firstOrCreate([]);
        $record->instrText = $this->data['instrText'];
        $record->save();
        Notification::make()->title('Saved')->success()->send();
    }
}

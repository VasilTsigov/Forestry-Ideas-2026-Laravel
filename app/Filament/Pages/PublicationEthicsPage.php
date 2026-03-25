<?php

namespace App\Filament\Pages;

use App\Domains\Page\Models\PublicationEthics;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use FilamentTiptapEditor\TiptapEditor;

class PublicationEthicsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $navigationLabel = 'Publication Ethics';
    protected static ?string $title = 'Publication Ethics';
    protected static ?string $navigationGroup = 'Pages';
    protected static ?int $navigationSort = 11;
    protected static string $view = 'filament.pages.content-page';

    public ?array $data = [];

    public function mount(): void
    {
        $record = PublicationEthics::firstOrCreate([]);
        $this->form->fill(['content' => $record->content]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TiptapEditor::make('content')->label('')->profile('default')->columnSpanFull(),
        ])->statePath('data');
    }

    public function save(): void
    {
        $record = PublicationEthics::firstOrCreate([]);
        $record->content = $this->data['content'];
        $record->save();
        Notification::make()->title('Saved')->success()->send();
    }
}

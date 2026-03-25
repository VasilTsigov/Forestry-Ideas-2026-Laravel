<?php

namespace App\Filament\Pages;

use App\Domains\Page\Models\Home;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use FilamentTiptapEditor\TiptapEditor;

class HomePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Home';
    protected static ?string $title = 'Home Page';
    protected static ?string $navigationGroup = 'Pages';
    protected static ?int $navigationSort = 13;
    protected static string $view = 'filament.pages.content-page';

    public ?array $data = [];

    public function mount(): void
    {
        $record = Home::firstOrCreate([]);
        $this->form->fill(['homeText' => $record->homeText]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TiptapEditor::make('homeText')->label('')->profile('default')->columnSpanFull(),
        ])->statePath('data');
    }

    public function save(): void
    {
        $record = Home::firstOrCreate([]);
        $record->homeText = $this->data['homeText'];
        $record->save();
        Notification::make()->title('Saved')->success()->send();
    }
}

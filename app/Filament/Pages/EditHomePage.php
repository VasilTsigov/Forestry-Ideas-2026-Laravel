<?php

namespace App\Filament\Pages;

use App\Domains\Page\Models\Home;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditHomePage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Home';
    protected static ?string $title = 'Home Page';
    protected static ?string $navigationGroup = 'Content Pages';
    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.pages.edit-single-content-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            Home::firstOrCreate([])->only(['homeText'])
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('homeText')
                    ->label('Съдържание')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        Home::firstOrCreate([])->update($this->data);

        Notification::make()
            ->title('Записано успешно')
            ->success()
            ->send();
    }

}

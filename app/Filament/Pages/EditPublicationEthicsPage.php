<?php

namespace App\Filament\Pages;

use App\Domains\Page\Models\PublicationEthics;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditPublicationEthicsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Publication Ethics';
    protected static ?string $title = 'Publication Ethics';
    protected static ?string $navigationGroup = 'Content Pages';
    protected static ?int $navigationSort = 11;

    protected static string $view = 'filament.pages.edit-single-content-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            PublicationEthics::firstOrCreate([])->only(['content'])
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('content')
                    ->label('Съдържание')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        PublicationEthics::firstOrCreate([])->update($this->data);

        Notification::make()
            ->title('Записано успешно')
            ->success()
            ->send();
    }
}

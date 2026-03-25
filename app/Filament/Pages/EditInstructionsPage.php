<?php

namespace App\Filament\Pages;

use App\Domains\Page\Models\InstructionToAuthors;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditInstructionsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Instructions to Authors';
    protected static ?string $title = 'Instructions to Authors';
    protected static ?string $navigationGroup = 'Content Pages';
    protected static ?int $navigationSort = 12;

    protected static string $view = 'filament.pages.edit-single-content-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            InstructionToAuthors::firstOrCreate([])->only(['instrText'])
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('instrText')
                    ->label('Съдържание')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        InstructionToAuthors::firstOrCreate([])->update($this->data);

        Notification::make()
            ->title('Записано успешно')
            ->success()
            ->send();
    }
}

<?php

namespace App\Filament\Pages;

use App\Domains\Page\Models\Subscription;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditSubscriptionPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Subscription';
    protected static ?string $title = 'Subscription';
    protected static ?string $navigationGroup = 'Content Pages';
    protected static ?int $navigationSort = 13;

    protected static string $view = 'filament.pages.edit-single-content-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            Subscription::firstOrCreate([])->only(['content'])
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
        Subscription::firstOrCreate([])->update($this->data);

        Notification::make()
            ->title('Записано успешно')
            ->success()
            ->send();
    }
}

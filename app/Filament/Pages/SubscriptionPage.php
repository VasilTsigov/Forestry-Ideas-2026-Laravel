<?php

namespace App\Filament\Pages;

use App\Domains\Page\Models\Subscription;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use FilamentTiptapEditor\TiptapEditor;

class SubscriptionPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Subscription';
    protected static ?string $title = 'Subscription';
    protected static ?string $navigationGroup = 'Pages';
    protected static ?int $navigationSort = 10;
    protected static string $view = 'filament.pages.content-page';

    public ?array $data = [];

    public function mount(): void
    {
        $subscription = Subscription::firstOrCreate([]);
        $this->form->fill(['content' => $subscription->content]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TiptapEditor::make('content')
                        ->label('')
                        ->profile('default')
                        ->columnSpanFull(),
                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $subscription = Subscription::firstOrCreate([]);
        $subscription->content = $this->data['content'];
        $subscription->save();

        Notification::make()->title('Saved')->success()->send();
    }
}

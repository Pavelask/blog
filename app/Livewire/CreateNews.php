<?php

namespace App\Livewire;

use App\Models\NewsModel;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateNews extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('name')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('description')
                    ->rows(7)
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->label('slug')
                    ->maxLength(255),
                TextInput::make('sort')
                    ->label('sort')
                    ->maxLength(255)
                    ->default(500),
                Toggle::make('is_visible')
                    ->label('OFF|ON')
                    ->inline(false)
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user'),
            ])->columns(3)
            ->statePath('data');
    }

    public function create(): void
    {
//        dd($this->form->getState());
        NewsModel::create($this->form->getState());

        Notification::make()
            ->title('Анкета участника успешно добавлена')
            ->body('Анкета будет проверена и в случае необходимости с Вами свяжутся')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->color('success')
            ->seconds(10)
            ->send();

        $this->redirectRoute('list_news');
    }

    public function render(): View

    {
        return view('livewire.create-news')->layout('layouts.news');
    }
}

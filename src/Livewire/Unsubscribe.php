<?php

namespace Dashed\DashedTernair\Livewire;

use Dashed\DashedTernair\Classes\FormApis\NewsletterAPI;
use Dashed\DashedTranslations\Models\Translation;
use Filament\Notifications\Notification;
use Livewire\Component;

class Unsubscribe extends Component
{
    public ?string $ezineCode = '';
    public ?string $tid = '';

    public function mount()
    {
        $this->ezineCode = request()->get('ezinecode');
        $this->tid = request()->get('tid');
    }

    public function submit()
    {
        if(!$this->ezineCode || !$this->tid) {
            return;
        }

        NewsletterAPI::unsubscribe($this->ezineCode, $this->tid);

        Notification::make()
            ->body(Translation::get('unsubscribed_from_newsletter', 'ternair-newsletter', 'U bent uitgeschreven van de nieuwsbrief.'))
            ->success()
            ->send();

        return redirect('/');
    }

    public function render()
    {
        return view(env('SITE_THEME', 'dashed') . '.ternair-newsletter.unsubscribe');
    }
}

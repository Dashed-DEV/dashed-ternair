<?php

namespace Dashed\DashedTernair\Livewire;

use Dashed\DashedTernair\Classes\FormApis\NewsletterAPI;
use Dashed\DashedTranslations\Models\Translation;
use Filament\Notifications\Notification;
use Livewire\Component;

class Confirm extends Component
{
    public ?string $aapKey = '';
    public ?string $tid = '';

    public function mount()
    {
        $this->aapKey = request()->get('aapkey');
        $this->tid = request()->get('tid');
    }

    public function submit()
    {
        if(!$this->aapKey || !$this->tid) {
            return;
        }

        NewsletterAPI::confirm($this->aapKey, $this->tid);

        Notification::make()
            ->body(Translation::get('confirmed_newsletter_subscription', 'ternair-newsletter', 'U bent aangemeld voor de nieuwsbrief.'))
            ->success()
            ->send();

        return redirect('/');
    }

    public function render()
    {
        return view(env('SITE_THEME', 'dashed') . '.ternair-newsletter.confirm');
    }
}

<?php

namespace Dashed\DashedTernair\Livewire;

use Dashed\DashedCore\Controllers\Frontend\FrontendController;
use Dashed\DashedTernair\Classes\FormApis\NewsletterAPI;
use Dashed\DashedTranslations\Models\Translation;
use Filament\Notifications\Notification;
use Livewire\Component;

class Confirm extends Component
{
    public ?string $aapKey = '';
    public ?string $tid = '';
    public array $blockData = [];

    public function mount(array $blockData = [])
    {
        $this->aapKey = request()->get('aapkey');
        $this->tid = request()->get('tid');
        $this->blockData = $blockData;

        if(!$this->aapKey) {
            return redirect('/');
        }

        $this->submit();
    }

    public function submit()
    {
        NewsletterAPI::confirm($this->aapKey, $this->tid);

        Notification::make()
            ->body(Translation::get('confirmed-newsletter-subscription', 'ternair-newsletter', 'U bent aangemeld voor de nieuwsbrief.'))
            ->success()
            ->send();

//        return redirect('/');
    }

    public function render()
    {
        return view(env('SITE_THEME', 'dashed') . '.ternair-newsletter.confirm');
    }
}

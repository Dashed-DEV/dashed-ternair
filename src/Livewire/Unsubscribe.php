<?php

namespace Dashed\DashedTernair\Livewire;

use Dashed\DashedCore\Controllers\Frontend\FrontendController;
use Dashed\DashedTernair\Classes\FormApis\NewsletterAPI;
use Dashed\DashedTranslations\Models\Translation;
use Filament\Notifications\Notification;
use Livewire\Component;

class Unsubscribe extends Component
{
    public ?string $ezineCode = '';
    public ?string $tid = '';
    public array $blockData = [];

    public function mount(array $blockData = [])
    {
        $this->ezineCode = request()->get('ezinecode');
        $this->tid = request()->get('tid');
        $this->blockData = $blockData;

        if(!$this->ezineCode || !$this->tid) {
            return redirect('/');
        }
    }

    public function submit()
    {
        NewsletterAPI::unsubscribe($this->ezineCode, $this->tid);

        Notification::make()
            ->body(Translation::get('unsubscribed-from-newsletter', 'ternair-newsletter', 'U bent uitgeschreven van de nieuwsbrief.'))
            ->success()
            ->send();

        return redirect('/');
    }

    public function render()
    {
        return view(env('SITE_THEME', 'dashed') . '.ternair-newsletter.unsubscribe');
    }
}

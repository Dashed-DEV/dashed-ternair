<?php

namespace Dashed\DashedTernair;

use Dashed\DashedTernair\Filament\Pages\Settings\DashedTernairSettingsPage;
use Filament\Panel;
use Filament\Contracts\Plugin;

class DashedTernairPlugin implements Plugin
{
    public function getId(): string
    {
        return 'dashed-ternair';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                DashedTernairSettingsPage::class,
            ]);
    }

    public function boot(Panel $panel): void
    {

    }
}

<?php

namespace Dashed\DashedTernair;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Dashed\DashedTernair\Filament\Resources\TernairResource;
use Dashed\DashedTernair\Filament\Pages\Settings\TernairSettingsPage;

class DashedTernairPlugin implements Plugin
{
    public function getId(): string
    {
        return 'dashed-ternair';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
            ]);
    }

    public function boot(Panel $panel): void
    {

    }
}

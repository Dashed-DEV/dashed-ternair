<?php

namespace Dashed\DashedTernair;

use Livewire\Livewire;
use Dashed\DashedTernair\Livewire\Ternair;
use Spatie\LaravelPackageTools\Package;
use Illuminate\Console\Scheduling\Schedule;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Dashed\DashedTernair\Commands\SendWebhooksForTernairInputs;
use Dashed\DashedTernair\Filament\Pages\Settings\TernairSettingsPage;

class DashedTernairServiceProvider extends PackageServiceProvider
{
    public static string $name = 'dashed-ternair';

    public function bootingPackage()
    {
    }

    public function configurePackage(Package $package): void
    {
        cms()->builder(
            'settingPages',
            array_merge(cms()->builder('settingPages'), [
                'ternairSettings' => [
                    'name' => 'Ternair instellingen',
                    'description' => 'Beheer instellingen voor Ternair',
                    'icon' => 'bell',
                    'page' => TernairSettingsPage::class,
                ],
            ])
        );

        $package
            ->name('dashed-ternair')
            ->hasViews();

    }
}

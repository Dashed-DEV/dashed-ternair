<?php

namespace Dashed\DashedTernair;

use Dashed\DashedTernair\Filament\Pages\Settings\DashedTernairSettingsPage;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Illuminate\Console\Scheduling\Schedule;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
                'dashedTernair' => [
                    'name' => 'Dashed Ternair instellingen',
                    'description' => 'Beheer instellingen voor Ternair',
                    'icon' => 'bell',
                    'page' => DashedTernairSettingsPage::class,
                ],
            ])
        );

        $package
            ->name('dashed-ternair')
            ->hasViews();

    }
}

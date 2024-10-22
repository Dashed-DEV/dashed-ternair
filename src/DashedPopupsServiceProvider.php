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
        Livewire::component('dashed-ternair.ternair', Ternair::class);

//        $this->app->booted(function () {
//            $schedule = app(Schedule::class);
//        });
    }

    public function configurePackage(Package $package): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../resources/templates' => resource_path('views/' . env('SITE_THEME', 'dashed')),
        ], 'dashed-templates');

//        cms()->builder(
//            'settingPages',
//            array_merge(cms()->builder('settingPages'), [
//                'ternairNotifications' => [
//                    'name' => 'Ternairulier instellingen',
//                    'description' => 'Beheer instellingen voor de ternairulieren',
//                    'icon' => 'bell',
//                    'page' => TernairSettingsPage::class,
//                ],
//            ])
//        );

        $package
            ->name('dashed-ternair')
            ->hasViews();

    }
}

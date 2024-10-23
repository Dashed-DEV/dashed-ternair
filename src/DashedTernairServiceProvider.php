<?php

namespace Dashed\DashedTernair;

use Dashed\DashedTernair\Classes\FormApis\NewsletterAPI;
use Dashed\DashedTernair\Classes\FormWebhooks\Webhook;
use Dashed\DashedTernair\Filament\Pages\Settings\DashedTernairSettingsPage;
use Spatie\LaravelPackageTools\Package;
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

        forms()->builder(
            'webhookClasses',
            array_merge(cms()->builder('webhookClasses'), [
                'ternair-webhook-1' => [
                    'name' => 'Ternair webhook',
                    'class' => Webhook::class,
                ],
            ])
        );

        forms()->builder(
            'apiClasses',
            array_merge(cms()->builder('apiClasses'), [
                'ternair-newsletters-api' => [
                    'name' => 'Ternair newsletter API',
                    'class' => NewsletterAPI::class,
                ],
            ])
        );

        $package
            ->name('dashed-ternair')
            ->hasViews();

    }
}

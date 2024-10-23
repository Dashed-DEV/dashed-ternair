<?php

namespace Dashed\DashedTernair\Filament\Pages\Settings;

use Filament\Pages\Page;
use Dashed\DashedCore\Models\User;
use Filament\Forms\Components\Tabs;
use Dashed\DashedCore\Classes\Sites;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Placeholder;
use Dashed\DashedCore\Models\Customsetting;
use Dashed\DashedForms\Classes\MailingProviders\ActiveCampaign;

class DashedTernairSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationLabel = 'Formulier instellingen';
    protected static ?string $navigationGroup = 'Overige';
    protected static ?string $title = 'Formulier instellingen';

    protected static string $view = 'dashed-core::settings.pages.default-settings';
    public array $data = [];

    public function mount(): void
    {
        $formData = [];

        $sites = Sites::getSites();
        foreach ($sites as $site) {
            $formData["ternair_x_api_application_header_{$site['id']}"] = Customsetting::get('ternair_x_api_application_header', $site['id']);
            $formData["ternair_api_username_{$site['id']}"] = Customsetting::get('ternair_api_username', $site['id']);
            $formData["ternair_api_password_{$site['id']}"] = Customsetting::get('ternair_api_password', $site['id']);
        }

        $this->form->fill($formData);
    }

    protected function getFormSchema(): array
    {
        $sites = Sites::getSites();
        $tabGroups = [];

        $tabs = [];
        foreach ($sites as $site) {
            $schema = [
                TextInput::make("ternair_x_api_application_header_{$site['id']}")
                    ->label('X-API-Application-Header voor de Ternair API')
                    ->reactive(),
                TextInput::make("ternair_api_username_{$site['id']}")
                    ->label('API username')
                    ->reactive(),
                TextInput::make("ternair_api_password_{$site['id']}")
                    ->label('API wachtwoord')
                    ->password()
                    ->reactive(),
            ];

            $tabs[] = Tab::make($site['id'])
                ->label(ucfirst($site['name']))
                ->schema($schema)
                ->columns([
                    'default' => 1,
                    'lg' => 2,
                ]);
        }
        $tabGroups[] = Tabs::make('Sites')
            ->tabs($tabs);

        return $tabGroups;
    }

    public function getFormStatePath(): ?string
    {
        return 'data';
    }

    public function submit()
    {
        $sites = Sites::getSites();
        $formState = $this->form->getState();

        foreach ($sites as $site) {
            Customsetting::set('ternair_x_api_application_header', $this->form->getState()["ternair_x_api_application_header_{$site['id']}"], $site['id']);
            Customsetting::set('ternair_api_username', $this->form->getState()["ternair_api_username_{$site['id']}"], $site['id']);
            Customsetting::set('ternair_api_password', $this->form->getState()["ternair_api_password_{$site['id']}"], $site['id']);
        }

        $this->form->fill($formState);

        Notification::make()
            ->title('De Dashed Ternair instellingen zijn opgeslagen')
            ->success()
            ->send();
    }
}

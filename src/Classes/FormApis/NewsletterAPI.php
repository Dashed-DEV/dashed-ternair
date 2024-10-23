<?php

namespace Dashed\DashedTernair\Classes\FormApis;

use Dashed\DashedCore\Models\Customsetting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Dashed\DashedForms\Models\FormInput;

class NewsletterAPI
{
    public static function dispatch(FormInput $formInput, $api)
    {
        $data = [];
        $data['IpAddress'] = $formInput->ip;
        $data['EzineCode'] = $api['EzineCode'];
        $data['SendOptinMail'] = (bool)$api['SendOptinMail'];
        $data['SendConfirmationMail'] = (bool)$api['SendConfirmationMail'];
        $data['Email'] = $formInput->formFields->where('form_field_id', $api['email_field_id'])->first()->value ?? null;
        $data['Fingerprint'] = $formInput->formFields->where('form_field_id', $api['tid_field_id'])->first()->value ?? null;
        $data['Tid'] = $formInput->formFields->where('form_field_id', $api['fingerprint_field_id'])->first()->value ?? null;
        $data['Firstname'] = $formInput->formFields->where('form_field_id', $api['firstname_field_id'])->first()->value ?? null;
        $data['Middlename'] = $formInput->formFields->where('form_field_id', $api['middlename_field_id'])->first()->value ?? null;
        $data['Lastname'] = $formInput->formFields->where('form_field_id', $api['lastname_field_id'])->first()->value ?? null;

        foreach ($formInput->formFields as $field) {
            $data['data'][$field->formField->name] = $field->formField->type == 'file' ? Storage::disk('dashed')->url($field->value) : $field->value;
        }

        foreach (str(str($formInput->from_url)->explode('?')->last())->explode('&') as $query) {
            $query = str($query)->explode('=');
            $data[$query[0]] = $query[1] ?? '';
            $data['queryParams'][$query[0]] = $query[1] ?? '';
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-Application' => Customsetting::get('x_api_application_header'),
        ])->post('https://campaign3-interact-api.ternairsoftware.com/subscription/newsletter', $data);

        if ($response->failed()) {
            $formInput->api_error = $response->body();
        }

        $formInput->api_send = $response->successful() ? 1 : 2;
        $formInput->save();
    }

    public static function formFields(): array
    {
        return [
            TextInput::make('EzineCode')
                ->label('Ezine code')
                ->required(),
            Toggle::make('SendOptinMail')
                ->label('Stuur optin mail'),
            Toggle::make('SendConfirmationMail')
                ->label('Stuur bevestigingsmail'),
            Select::make('email_field_id')
                ->label('Email veld')
                ->required()
                ->options(fn($record) => $record ? $record->fields()->where('type', 'input')->where('input_type', 'email')->pluck('name', 'id') : []),
            Select::make('firstname_field_id')
                ->label('Voornaam veld')
                ->options(fn($record) => $record ? $record->fields()->where('type', 'input')->pluck('name', 'id') : []),
            Select::make('middlename_field_id')
                ->label('Tussenvoegsel veld')
                ->options(fn($record) => $record ? $record->fields()->where('type', 'input')->pluck('name', 'id') : []),
            Select::make('lastname_field_id')
                ->label('Achternaam veld')
                ->options(fn($record) => $record ? $record->fields()->where('type', 'input')->pluck('name', 'id') : []),
            Select::make('tid_field_id')
                ->label('TID veld')
                ->required()
                ->options(fn($record) => $record ? $record->fields()->where('type', 'input')->pluck('name', 'id') : []),
            Select::make('fingerprint_field_id')
                ->label('Fingerprint veld')
                ->required()
                ->options(fn($record) => $record ? $record->fields()->where('type', 'input')->pluck('name', 'id') : []),
        ];
    }
}

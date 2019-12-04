<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sms' => [
        'default' => env('DEFAULT_SMS_PROVIDER', 'twilio'),
        'providers' => [
            'twilio' => [
                'key' => env('TWILIO_SID', ''),
                'secret' => env('TWILIO_AUTH_TOKEN', ''),
                'class' => \App\Services\TransportProviders\TwilioProvider::class,
                'from_phone_number' => env('TWILIO_FROM_SMS_NUMBER', ''),
            ],
            'nexmo' => [
                'key' => env('NEXMO_KEY', ''),
                'secret' => env('NEXMO_SECRET', ''),
                'class' => \App\Services\TransportProviders\NexmoProvider::class,
                'from_phone_number' => env('FROM_SMS_NUMBER', ''),
            ],
        ],
    ]

];

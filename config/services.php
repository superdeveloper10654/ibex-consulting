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

    'teams' => [
        'webhook_url' => env('TEAMS_WEBHOOK_URL', 'https://bssl.webhook.office.com/webhookb2/0d7f22f8-ac5a-421c-9786-e8c436a8a75c@51d1b04d-3c9b-45c7-b7cb-1e56cd87ec5e/IncomingWebhook/319e7e0c2d40400d8806152547af7ed8/06560132-70ba-4505-98fe-094a6421e67c'),
       // 'webhook_url' => env('TEAMS_WEBHOOK_URL', 'https://bssl.webhook.office.com/webhookb2/0d7f22f8-ac5a-421c-9786-e8c436a8a75c@51d1b04d-3c9b-45c7-b7cb-1e56cd87ec5e/IncomingWebhook/319e7e0c2d40400d8806152547af7ed8/06560132-70ba-4505-98fe-094a6421e67c'),
    ],
  


];

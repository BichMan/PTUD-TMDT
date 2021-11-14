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
    'facebook' => [
        'client_id' => '300995878694592',  //client face của bạn
        'client_secret' => '412ce88072e933294389fb75a0c98a65',  //client app service face của bạn
        'redirect' => 'http://localhost/vyshop/admin/callback' //callback trả về
    ],
    'google' => [
        'client_id' => '804434876179-kdhr1fr94qdbegrcollkfmqb78rhf6r3.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost/vyshop/google/callback'
    ],

];

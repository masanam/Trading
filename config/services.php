<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        //'key' => 'AKIAJFNN2RRNX3XEF7VQ', // || env('SES_KEY'),
        //'secret' => 'B1vE1I7Z4I1KQ4OEqLD/qHYKxXmwC', // || env('SES_SECRET'),
        'key' => 'AKIAJRG2I4ERK35XSJJA',
        'secret' => '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',
        'region' => 'us-east-1'
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'firebase' => [
        'api_key' => 'AIzaSyACILHAOiy4G9TtCgs0szgZBZokr4cduuo',
        'auth_domain' => 'coal-trade.firebaseapp.com',
        'database_url' => 'https://coal-trade.firebaseio.com',
        'secret' => 'HDhmUXlH4E85A3PdxbfQGw0yCiqy0Bjvugbuqs8t',
        'storage_bucket' => 'coal-trade.appspot.com',
    ],

    'firebase_dev' => [
        'api_key' => 'AIzaSyASD5vZNA-DeS93cFU8oz40nycp1CIZ3bg',
        'auth_domain' => 'coal-trade-dev.firebaseapp.com',
        'database_url' => 'https://coal-trade-dev.firebaseio.com',
        'secret' => 'f8wEJWpGWfTw9n3oOZdVjw95woQrnzPQR5csRR35',
        'storage_bucket' => 'coal-trade-dev.appspot.com',
        'messaging_sender_id' => '328150955221'
    ],

];

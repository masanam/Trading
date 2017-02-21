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

    'firebase_bce' => [
        'api_key' => 'AIzaSyCxlQjskah9WwqykW9oU3k6250HQWfhfws',
        'auth_domain' => 'coal-trade-bce.firebaseapp.com',
        'database_url' => 'https://coal-trade-bce.firebaseio.com',
        'secret' => 'GYCw3qfxhS0SKtU4fwZRdceGuSqJiZfmRkjci46t',
        'storage_bucket' => 'coal-trade-bce.appspot.com',
        'messaging_sender_id' => '202440433886'
    ],

    'firebase_dev' => [
        'api_key' => 'AIzaSyASD5vZNA-DeS93cFU8oz40nycp1CIZ3bg',
        'auth_domain' => 'coal-trade-dev.firebaseapp.com',
        'database_url' => 'https://coal-trade-dev.firebaseio.com',
        'secret' => 'f8wEJWpGWfTw9n3oOZdVjw95woQrnzPQR5csRR35',
        'storage_bucket' => 'coal-trade-dev.appspot.com',
        'messaging_sender_id' => '328150955221'
    ],

    'firebase_bce_dev' => [
        'api_key' => 'AIzaSyCA9Y_d68CnRkKtZLeqNT0GheGx0SIlljM',
        'auth_domain' => 'coal-trade-bce-dev.firebaseapp.com',
        'database_url' => 'https://coal-trade-bce-dev.firebaseio.com',
        'secret' => 'eqfunIbg6UuCXf9pr80ZYs94tZQCLC0F0Utmh5OU',
        'storage_bucket' => 'coal-trade-bce-dev.appspot.com',
        'messaging_sender_id' => '79426855083'
    ],
];

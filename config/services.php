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
    'google' => [
        'client_id' => '188618463309-nma6f4fkichq8q79rr9ij0ssc5uvn513.apps.googleusercontent.com',
        'client_secret' => 'eWMUpL_N4K7aJ1WAJSVNQexA',
        'redirect' => 'http://shaadiportal.testing/social/google/output',
    ],

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

    'paytm-wallet' => [
        'env' => 'production', // values : (local | production)
        'merchant_id' => 'NESTOR42509796971890',
        'merchant_key' => 'yZt!E@hjd9AgJ5aM',
        // 'merchant_id' => 'yEcytO49536340286191',
        // 'merchant_key' => 'wzL8t&aSOeWrFvwY',
        'merchant_website' => 'DEFAULT',
        'channel' => 'WEB',
        'industry_type' => 'Retail',
        'callback_url' => 'http://nestor_update.testing/payment_callback',
    ],

    'google' => [
        'client_id' => '188618463309-qdvphct9mabl44288c00ppvmtes3n1oh.apps.googleusercontent.com',
        'client_secret' => '-vVQLa4bjHL4w8a4UOaKJS-w',
        'redirect' => 'http://127.0.0.1:8000/socialite/google/callback',
    ],

    'facebook' => [
        'client_id' => 'xxxx',
        'client_secret' => 'xxx',
        'redirect' => 'https://www.tutsmake.com/laravel-example/callback/facebook',
    ],

];
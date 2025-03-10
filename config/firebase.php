<?php

return [
    'credentials' => env('FIREBASE_CREDENTIALS'),

    'database_url' => env('FIREBASE_DATABASE_URL', null),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', null),

    'auth' => [
        'default_tenant' => env('FIREBASE_AUTH_DEFAULT_TENANT', null),
    ],

    'messaging' => [
        'default_topic' => env('FIREBASE_MESSAGING_DEFAULT_TOPIC', null),
    ],

    'dynamic_links' => [
        'default_domain' => env('FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN', null),
    ],

    'debug' => env('FIREBASE_DEBUG', false),
];

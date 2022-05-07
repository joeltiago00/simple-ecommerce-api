<?php

return [
    'bucket' => [
        'access_key' => env('AWS_BUCKET_ACCESS_KEY_ID'),
        'secret_access_key' => env('AWS_BUCKET_SECRET_ACCESS_KEY'),
        'default_region' => env('AWS_BUCKET_DEFAULT_REGION'),
        'name' => env('AWS_BUCKET'),
    ],
];

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Yandex Cloud OAuth Token
    |--------------------------------------------------------------------------
    |
    | Your Yandex Cloud OAuth token. You can get it from:
    | https://oauth.yandex.ru/authorize?response_type=token&client_id=1a6990aa636648e9b2ef855fa7bec2fb
    |
    */
    'oauth_token' => env('YANDEX_CLOUD_OAUTH_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Default Organization ID
    |--------------------------------------------------------------------------
    |
    | The default organization ID to use for API requests.
    | You can override this in your code when needed.
    |
    */
    'organization_id' => env('YANDEX_CLOUD_ORGANIZATION_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud ID
    |--------------------------------------------------------------------------
    |
    | The default cloud ID to use for API requests.
    | You can override this in your code when needed.
    |
    */
    'cloud_id' => env('YANDEX_CLOUD_CLOUD_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Default Folder ID
    |--------------------------------------------------------------------------
    |
    | The default folder ID to use for API requests.
    | You can override this in your code when needed.
    |
    */
    'folder_id' => env('YANDEX_CLOUD_FOLDER_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Options
    |--------------------------------------------------------------------------
    |
    | Additional options for the HTTP client (Guzzle).
    |
    */
    'http' => [
        'timeout' => env('YANDEX_CLOUD_TIMEOUT', 30),
        'connect_timeout' => env('YANDEX_CLOUD_CONNECT_TIMEOUT', 10),
    ],
];

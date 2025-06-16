<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'admin/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://your-korona.ru'],
//    'allowed_origins' => ['http://localhost:3000'],

//    'allowed_origins_patterns' => [],
    'allowed_origins_patterns' => ['/^https?:\/\/your\-korona\.ru$/'],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];

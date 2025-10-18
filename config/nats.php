<?php

return [
    'host' => env('NATS_HOST', '127.0.0.1'),
    'port' => env('NATS_PORT', 4222),
    'user' => env('NATS_USER', null),
    'pass' => env('NATS_PASS', null),
    'tls' => [
        'enabled' => env('NATS_TLS_ENABLED', false),
        'ca_file' => env('NATS_TLS_CA_FILE', null),
        'cert_file' => env('NATS_TLS_CERT_FILE', null),
        'key_file' => env('NATS_TLS_KEY_FILE', null),
    ],
    'options' => [
        // any extra options forwarded to Configuration
    ],
];
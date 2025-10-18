<?php

use PealIhertz\LaravelNats\NatsManager;
use Basis\Nats\Client;

it('initializes Basis NATS client from config', function () {
    $config = [
        'host' => 'localhost',
        'port' => 4222,
        'user' => 'demo',
        'pass' => 'secret',
    ];

    $manager = new NatsManager($config);

    $client = $manager->client();
    expect($client)->toBeInstanceOf(Client::class);
});
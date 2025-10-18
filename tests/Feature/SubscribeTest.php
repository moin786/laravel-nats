<?php

use PealIhertz\LaravelNats\NatsManager;

it('can subscribe to subject and trigger callback', function () {
    $mockClient = Mockery::mock('Basis\\Nats\\Client');
    $mockClient->shouldReceive('subscribe')
        ->once()
        ->with('demo.subject', Mockery::type('callable'))
        ->andReturnTrue();

    $nats = new NatsManager();
    $reflection = new ReflectionClass($nats);
    $property = $reflection->getProperty('client');
    $property->setAccessible(true);
    $property->setValue($nats, $mockClient);

    $nats->subscribe('demo.subject', fn($msg) => null);
});
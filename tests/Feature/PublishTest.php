<?php

use PealIhertz\LaravelNats\NatsManager;

it('can publish message to subject', function () {
    $mockClient = Mockery::mock('Basis\\Nats\\Client');
    $mockClient->shouldReceive('publish')
        ->once()
        ->with('demo.subject', json_encode(['foo' => 'bar']));

    $nats = new NatsManager();
    $reflection = new ReflectionClass($nats);
    $property = $reflection->getProperty('client');
    $property->setAccessible(true);
    $property->setValue($nats, $mockClient);

    $nats->publish('demo.subject', json_encode(['foo' => 'bar']));
});
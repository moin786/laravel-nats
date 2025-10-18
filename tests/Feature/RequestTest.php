<?php

use PealIhertz\LaravelNats\NatsManager;

it('can send request and receive response', function () {
    $mockClient = Mockery::mock('Basis\\Nats\\Client');
    $mockClient->shouldReceive('request')
        ->once()
        ->with('demo.request', json_encode(['a' => 1, 'b' => 2]), 1.0)
        ->andReturn('response-data');

    $nats = new NatsManager();
    $reflection = new ReflectionClass($nats);
    $property = $reflection->getProperty('client');
    $property->setAccessible(true);
    $property->setValue($nats, $mockClient);

    $response = $nats->request('demo.request', json_encode(['a' => 1, 'b' => 2]), fn($response) => $response);
    expect($response)->toBe('response-data');
});
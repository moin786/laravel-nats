<?php

namespace PealIhertz\LaravelNats\Contracts;

interface NatsClientInterface
{
    public function publish(string $subject, $payload, array $headers = []): void;
    public function subscribe(string $subject, ?callable $callback = null, array $options = []);
    public function request(string $subject, $payload, callable $callback);
    public function ping(): bool;
    public function client();
}
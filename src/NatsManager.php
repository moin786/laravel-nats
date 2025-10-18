<?php

namespace PealIhertz\LaravelNats;

use Basis\Nats\Client as BasisClient;
use Basis\Nats\Configuration;
use Basis\Nats\Message\Payload;
use YourVendor\LaravelNats\Contracts\NatsClientInterface;

class NatsManager implements NatsClientInterface
{
    protected BasisClient $client;

    public function __construct(array $config = [])
    {
        $configuration = new Configuration(
            host: $config['host'] ?? '127.0.0.1',
            port: $config['port'] ?? 4222,
            user: $config['user'] ?? null,
            pass: $config['pass'] ?? null,
        );

        // optional TLS settings
        if (!empty($config['tls']['enabled'])) {
            if (!empty($config['tls']['ca_file'])) {
                $configuration->tlsCaFile = $config['tls']['ca_file'];
            }
            if (!empty($config['tls']['cert_file'])) {
                $configuration->tlsCertFile = $config['tls']['cert_file'];
            }
            if (!empty($config['tls']['key_file'])) {
                $configuration->tlsKeyFile = $config['tls']['key_file'];
            }
        }

        $this->client = new BasisClient($configuration);
    }

    public function publish(string $subject, $payload, array $headers = []): void
    {
        if (!$payload instanceof Payload) {
            $payload = new Payload(is_array($payload) ? json_encode($payload) : (string) $payload);
        }

        $this->client->publish($subject, $payload);
    }

    public function subscribe(string $subject, ?callable $callback = null, array $options = [])
    {
        $queue = $this->client->subscribe($subject);

        if ($callback) {
            // register callback style
            if (is_callable($callback)) {
                // register callback on client side
                // the underlying client supports passing a callback on subscribe
                return $this->client->subscribe($subject, $callback);
            }
        }

        return $queue;
    }

    public function request(string $subject, $payload, callable $callback)
    {
        return $this->client->request($subject, $payload, $callback);
    }

    public function ping(): bool
    {
        return $this->client->ping();
    }

    public function client()
    {
        return $this->client;
    }
}
<?php

namespace PealIhertz\LaravelNats\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NatsConsume extends Command
{
    protected $signature = 'nats:consume {subject} {--queue=}';
    protected $description = 'Consume messages from a NATS subject';

    public function handle()
    {
        $subject = $this->argument('subject');
        $queue = $this->option('queue');

        $this->info("Subscribing to subject: $subject");

        $nats = app('laravel-nats');

        $nats->subscribe($subject, function ($message) use ($subject) {
            // $message may be a Message object or raw payload depending on configuration
            $payload = is_object($message) && property_exists($message, 'payload') ? $message->payload : $message;
            $this->info("[$subject] " . json_encode($payload));
            // optionally process, push job, etc.
        });

        // start processing loop
        $nats->client()->process();
    }
}
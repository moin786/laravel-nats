<?php

namespace PealIhertz\LaravelNats\Facades;

use Illuminate\Support\Facades\Facade;

class Nats extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-nats';
    }
}
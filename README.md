# Laravel NATS Package

Laravel integration for [`basis-company/nats`](https://github.com/basis-company/nats.php)

## Installation

1. Require package (after publishing to Packagist or using local path):

```bash
composer require your-vendor/laravel-nats
```

2. Publish config (optional):

```bash
php artisan vendor:publish --provider="YourVendor\\LaravelNats\\NatsServiceProvider" --tag=config
```

3. Update your `.env` file:

```env
NATS_HOST=127.0.0.1
NATS_PORT=4222
```

4. Usage examples:

```php
use Nats;

// Publish
Nats::publish('orders.created', json_encode(['order_id' => 1]));

// Request/Response
$response = Nats::request('math.add', json_encode(['a' => 5, 'b' => 3]));
```

### Artisan Command

```bash
php artisan nats:consume orders.created
```

---

## Testing

Run Pest tests:

```bash
composer install
./vendor/bin/pest
```

---

## Features
- Publish / Subscribe / Request / Response
- Artisan consumer command
- Configurable TLS support
- Simple Facade and DI integration
- Ready for JetStream extensions

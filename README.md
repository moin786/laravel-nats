# 🚀 Laravel NATS Integration Package

### Effortless real-time communication for Laravel apps using [NATS.io](https://nats.io) via [basis-company/nats.php](https://github.com/basis-company/nats.php)

---

## 🧩 Overview

**Laravel NATS** is a wrapper package that allows Laravel developers to interact easily with the **NATS** messaging system.

NATS (Neural Autonomic Transport System) is a high-performance, lightweight messaging system for microservices, IoT, and distributed systems.

With this package, you can:

- 📤 **Publish** messages to NATS subjects
- 📩 **Subscribe** to messages
- 🔁 **Request/Reply** pattern using callbacks
- ⚙️ Integrate seamlessly within controllers, commands, or queued jobs
- 🧠 Use **Laravel Facades**, Service Container bindings, and Configuration
- 🧪 Test easily using **PestPHP**

---

## ⚙️ Installation

```bash
composer require peal-ihertz/laravel-nats dev-main
```

---

## 🧰 Configuration

Publish the config file (optional):

```bash
php artisan vendor:publish --tag=config
```

This will create:

```php
// config/nats.php

return [
    'host' => env('NATS_HOST', '127.0.0.1'),
    'port' => env('NATS_PORT', 4222),
];
```

You can connect your **Dockerized NATS** instance or remote cluster:

```env
NATS_HOST=nats
NATS_PORT=4222
```

---

## 🧱 Usage

### 🔹 Publish a Message

```php
use Nats;

Nats::publish('notifications.new', ['message' => 'New user registered']);
```

or manually with a payload:

```php
use Basis\Nats\Message\Payload;

$payload = new Payload(json_encode(['id' => 123]));
Nats::publish('orders.created', $payload);
```

---

### 🔹 Subscribe to a Subject

```php
use Nats;

Nats::subscribe('notifications.new', function ($msg) {
    $data = json_decode($msg->body, true);
    logger('New notification received:', $data);
});
```

---

### 🔹 Request/Reply (Callback Pattern)

NATS supports **RPC-style** communication through a request-reply mechanism.

**Client Side:**

```php
Nats::request('math.add', ['a' => 5, 'b' => 3], function ($response) {
    $data = json_decode($response->body, true);
    logger('Response from server:', $data);
});
```

**Server Side (Subscriber):**

```php
Nats::subscribe('math.add', function ($msg) {
    $data = json_decode($msg->body, true);
    $sum = $data['a'] + $data['b'];

    $msg->reply(json_encode(['sum' => $sum]));
});
```

✅ The callback executes once the reply arrives — making it ideal for interactive real-time systems.

---

### 🔹 Example Controller

```php
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nats;

class NatsController extends Controller
{
    public function send()
    {
        Nats::publish('notifications.new', ['event' => 'UserRegistered']);
        return response()->json(['message' => 'Notification sent!']);
    }

    public function request()
    {
        Nats::request('math.add', ['a' => 10, 'b' => 7], function ($response) {
            logger('Received reply:', [json_decode($response->body, true)]);
        });

        return response()->json(['status' => 'request sent']);
    }
}
```

---

## 🧠 Advanced Features

### 1. **JetStream Support (Optional)**

If you use **NATS JetStream**, you can extend this package to handle durable streams and message persistence.  
The underlying client supports JetStream commands and metadata.

### 2. **Durable Subscriptions**

Persistent subscriptions let you replay missed messages and process them at-least-once.

### 3. **Async Handling**

NATS supports fully asynchronous publish/subscribe and request/reply patterns.

### 4. **Clustered & Secure**

You can connect to multiple NATS servers, use TLS, and authentication via NATS tokens.

---

## 🧪 Testing

### Running Tests

This package uses **PestPHP**.

Run all tests:

```bash
./vendor/bin/pest
```

Feature tests example (`tests/Feature/NatsPublishTest.php`):

```php
it('can publish messages to nats', function () {
    $client = Mockery::mock(\Basis\Nats\Client::class);
    $client->shouldReceive('publish')->once();
    app()->instance(\Basis\Nats\Client::class, $client);

    Nats::publish('test.subject', ['foo' => 'bar']);
});
```

---

## 🐳 Example Docker Compose (for NATS testing)

```yaml
version: "3"
services:
  nats:
    image: nats:latest
    ports:
      - "4222:4222"
      - "8222:8222"
```

Run:

```bash
docker-compose up -d
```

---

## 💡 Why Use NATS with Laravel?

| Feature          | Description                               |
| ---------------- | ----------------------------------------- |
| ⚡ Speed         | Handles millions of messages per second   |
| 🧩 Simplicity    | Easy subject-based routing                |
| 🔁 Request/Reply | Built-in microservice communication       |
| ☁️ Scalable      | Cluster and stream messages easily        |
| 🧠 Lightweight   | Zero dependencies for core message broker |
| 🔐 Secure        | TLS and user authentication supported     |

---

## 🧾 License

MIT License © 2025 [Mohammed Minuddin Peal - iHERTZ Technology](https://ihertztech.com)

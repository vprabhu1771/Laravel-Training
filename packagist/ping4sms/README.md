```
https://www.ping4sms.com/
```

```
https://packagist.org/packages/manojkumarlinux/ping4sms
```

```
composer require manojkumarlinux/ping4sms
```

`.env`
```
PING4SMS_KEY=xxxxxxxxxxxxxxxxxxxxxx
PING4SMS_SENDER_ID=XXXXX
```

`config/services.php`

```php
'ping4sms' => [
    'key' => env('PING4SMS_KEY'),
    'sender_id' => env('PING4SMS_SENDER_ID'),
],
```

# Controller.
```php
public function sendSMS() {
    $message = new Ping4SMS(config('services.ping4sms.key'),config('services.ping4sms.sender_id'));
    $message->destination($mobile)->message($message)->route(2)->templateId(123456789)->send();
}
```

# OR
```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Ping4SMS\Ping4SMS;

$message = new Ping4SMS('Account key','Sender id');

//  send message
$message->destination('Mobile Number')->message('Your Message')->route('Route Number')->templateId('DLT_Templateid')->send();

// Delivery Report Api
$message->deliveryId("delivery id")->deliveryReport();

// Credits Check Api
$message->route("Route Number")->creditsCheck(); 
```

// don't forget clear laravel catch. 
```bash
php artisan config:cache
```

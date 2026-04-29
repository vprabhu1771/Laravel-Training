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

// don't forget clear laravel catch. 
```bash
php artisan config:cache
```

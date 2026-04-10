You just need to pull your Mailtrap API key from the `.env` file using Laravel’s `env()` helper.

### ✅ Step 1: Add in `.env`

```env
MAILTRAP_API_KEY=your_mailtrap_api_key_here
```

---

### ✅ Step 2: Use it in your Artisan command

Update your command like this:

```php
Artisan::command('send-mail', function () {
    $email = (new MailtrapEmail())
        ->from(new Address('hello@bughunt.in', 'Mailtrap Test'))
        ->to(new Address('bughunt321@gmail.com'))
        ->subject('You are awesome!')
        ->category('Integration Test')
        ->text('Congrats for sending test email with Mailtrap!');

    $response = MailtrapClient::initSendingEmails(
        apiKey: env('MAILTRAP_API_KEY') // 👈 from .env
    )->send($email);

    var_dump(ResponseHelper::toArray($response));
})->purpose('Send Mail');
```

---

### ⚠️ Important (Best Practice)

Using `env()` directly inside code (like commands) is okay for testing, but **recommended approach** is:

### ✅ Step 3: Use config file (Better way)

#### In `config/services.php`

```php
'mailtrap' => [
    'api_key' => env('MAILTRAP_API_KEY'),
],
```

#### Then in your command:

```php
$response = MailtrapClient::initSendingEmails(
    apiKey: config('services.mailtrap.api_key')
)->send($email);
```

---

### 🔄 Step 4: Clear config cache (very important)

Run:

```bash
php artisan config:clear
php artisan cache:clear
```

---

### 🎯 Summary

* Store key in `.env`
* Access via `env()` OR `config()`
* Prefer `config()` for production


To run your Artisan console command (`send-mail`), follow these steps:

---

### ✅ 1. Open Terminal / Command Prompt

Go to your Laravel project folder:

```bash
cd /path/to/your/project
```

---

### ✅ 2. Run the command

```bash
php artisan send-mail
```

---

### ✅ 3. Expected Output

If everything is correct, you’ll see a response like:

```php
array( ... )
```

(This is from your `var_dump(ResponseHelper::toArray($response));`)

---

### ❗ If it doesn’t work, check these:

#### 🔹 API Key Missing

Make sure `.env` has:

```env
MAILTRAP_API_KEY=your_key_here
```

#### 🔹 Config Cache Issue

Run:

```bash
php artisan config:clear
php artisan cache:clear
```

---

### ✅ Optional: Debug Output (Cleaner)

Instead of `var_dump`, use:

```php
$this->info(json_encode(ResponseHelper::toArray($response), JSON_PRETTY_PRINT));
```

---

If you want, I can also help you convert this into a **proper Laravel Mail class (Mailable)** instead of Artisan command 👍

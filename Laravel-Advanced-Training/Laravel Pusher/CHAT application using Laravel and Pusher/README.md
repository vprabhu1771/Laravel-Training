#  I built a CHAT application in 5 MINUTES using Laravel and Pusher! 

```
https://www.youtube.com/watch?v=ER-wOKXrbuw
```

Great! Here's a **simple real-time chat app** using **Laravel + MySQL + Laravel WebSockets + Laravel Echo + Vue.js (or plain JS)**.

---

## 🔧 1. Laravel Setup (Backend)

### a. Install Laravel and set up MySQL

```bash
laravel new chat-app
cd chat-app
cp .env.example .env
php artisan key:generate
```

Configure `.env` to use your MySQL DB.

---

### b. Install Laravel WebSockets

```bash
composer require beyondcode/laravel-websockets
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider"
php artisan migrate
```

Start the WebSocket server:

```bash
php artisan websockets:serve
```

---

### c. Setup Broadcasting

#### In `.env`:

```env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
```

#### In `config/broadcasting.php`:

```php
'pusher' => [
    'driver' => 'pusher',
    'key' => env('PUSHER_APP_KEY'),
    'secret' => env('PUSHER_APP_SECRET'),
    'app_id' => env('PUSHER_APP_ID'),
    'options' => [
        'cluster' => 'mt1',
        'useTLS' => false,
        'host' => env('PUSHER_HOST', '127.0.0.1'),
        'port' => env('PUSHER_PORT', 6001),
        'scheme' => env('PUSHER_SCHEME', 'http'),
    ],
],
```

---

### d. Create `Message` model and migration

```bash
php artisan make:model Message -m
```

In the migration file:

```php
$table->id();
$table->string('user');
$table->text('message');
$table->timestamps();
```

```bash
php artisan migrate
```

---

### e. Create a Broadcast Event

```bash
php artisan make:event MessageSent
```

In `MessageSent.php`:

```php
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    public $user;
    public $message;

    public function __construct($user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return ['chat'];
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}
```

---

### f. Create API route and controller

```bash
php artisan make:controller ChatController
```

In `routes/api.php`:

```php
Route::post('/messages', [ChatController::class, 'send']);
Route::get('/messages', [ChatController::class, 'get']);
```

In `ChatController.php`:

```php
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $message = Message::create([
            'user' => $request->user,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message->user, $message->message))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }

    public function get()
    {
        return Message::orderBy('created_at')->get();
    }
}
```

---

## 🖥️ 2. Frontend: Example with HTML + JS

### a. Install Laravel Echo and Pusher

```bash
npm install --save laravel-echo pusher-js
```

### b. Setup in `resources/js/bootstrap.js`

```js
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'local',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});
```

---

### c. Example HTML + JS (public/chat.html)

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
</head>
<body>
    <h2>Chat App</h2>
    <div id="messages"></div>
    <input id="user" placeholder="Your name" />
    <input id="message" placeholder="Message" />
    <button onclick="send()">Send</button>

    <script src="/js/app.js"></script>
    <script>
        async function loadMessages() {
            const res = await fetch('/api/messages');
            const data = await res.json();
            data.forEach(msg => {
                document.getElementById('messages').innerHTML += `<p><b>${msg.user}:</b> ${msg.message}</p>`;
            });
        }

        async function send() {
            const user = document.getElementById('user').value;
            const message = document.getElementById('message').value;
            await fetch('/api/messages', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({user, message})
            });
        }

        window.Echo.channel('chat')
            .listen('.message.sent', (e) => {
                document.getElementById('messages').innerHTML += `<p><b>${e.user}:</b> ${e.message}</p>`;
            });

        loadMessages();
    </script>
</body>
</html>
```

---

## ✅ Final Steps

1. Run the following:

   ```bash
   php artisan serve
   php artisan websockets:serve
   npm run dev
   ```

2. Visit: `http://localhost:8000/chat.html`

---

## ✅ Done! You now have:

* Messages stored in MySQL
* Realtime chat with Laravel WebSockets + Echo
* Live updates across clients

Would you like me to package this as a GitHub-ready project or add user authentication (e.g., Laravel Breeze)?

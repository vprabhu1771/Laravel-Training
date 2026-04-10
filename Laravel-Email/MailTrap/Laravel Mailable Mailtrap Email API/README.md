Got it — you want to send an **Invoice email using Mailtrap Email API (not SMTP)** in Laravel 👍
Let’s do it cleanly using your existing `MailtrapClient`.

---

# ✅ 1. `.env` setup

```env
MAILTRAP_API_KEY=your_mailtrap_api_key
```

---

# ✅ 2. Create Invoice HTML (Blade or inline)

You can either:

* Use Blade and render it
* OR write HTML directly

### 👉 Recommended: Use Blade

`resources/views/emails/invoice.blade.php`

```html
<h2 style="margin-bottom:10px;">Invoice</h2>

<p><strong>Customer:</strong> {{ $data['name'] }}</p>
<p><strong>Amount:</strong> ₹{{ $data['amount'] }}</p>
<p><strong>Date:</strong> {{ $data['date'] }}</p>

<hr>

<h4>Bank Details</h4>
<p>
Bank: Bank of Baroda<br>
Account No: 12345<br>
IFSC: BOB67890
</p>
```

---

# ✅ 3. Artisan Command (Mailtrap API)

Update your command like this:

```php
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

Artisan::command('send-invoice', function () {

    $data = [
        'name' => 'Prabhu',
        'amount' => 5000,
        'date' => now()->format('d-m-Y'),
    ];

    // Render Blade to HTML
    $html = view('emails.invoice', ['data' => $data])->render();

    $email = (new MailtrapEmail())
        ->from(new Address('hello@bughunt.in', 'Invoice App'))
        ->to(new Address('bughunt321@gmail.com'))
        ->subject('Your Invoice')
        ->category('Invoice')
        ->html($html) // 👈 HTML invoice
        ->text("Invoice for {$data['name']} - Amount: ₹{$data['amount']}");

    $response = MailtrapClient::initSendingEmails(
        apiKey: config('services.mailtrap.api_key') // from .env
    )->send($email);

    $this->info(json_encode(ResponseHelper::toArray($response), JSON_PRETTY_PRINT));

})->purpose('Send Invoice via Mailtrap API');
```

---

# ✅ 4. Run Command

```bash
php artisan send-invoice
```

---

# ✅ 5. (Optional) Attach PDF Invoice

If you want PDF:

```bash
composer require barryvdh/laravel-dompdf
```

Then:

```php
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('pdf.invoice', $data);

$email->attach(
    $pdf->output(),
    'invoice.pdf',
    'application/pdf'
);
```

---

# ⚠️ Common Mistakes

❌ API key empty
❌ Forgot `config:clear`
❌ Wrong email format
❌ Blade not rendering

---

# 🎯 Final Result

* Email sent via **Mailtrap API**
* Invoice rendered as **HTML**
* Optional **PDF attachment**
* Fully dynamic data

---

If you want, I can build a **GST-style professional invoice (table, totals, tax, logo)** ready for API + PDF 👍

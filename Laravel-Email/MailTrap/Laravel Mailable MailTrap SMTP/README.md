To send an **Invoice email using Mailtrap in Laravel**, the best approach is to use a **Mailable + Blade template** (instead of only Artisan command). I’ll guide you step by step 👇

---

# ✅ 1. Setup Mailtrap API (already done by you)

In `.env`:

```env
MAILTRAP_API_KEY=your_api_key
```

In `config/services.php`:

```php
'mailtrap' => [
    'api_key' => env('MAILTRAP_API_KEY'),
],
```

---

# ✅ 2. Create Mailable

Run:

```bash
php artisan make:mail InvoiceMail
```

---

# ✅ 3. Update Mailable Class

`app/Mail/InvoiceMail.php`

```php
use Illuminate\Mail\Mailable;

class InvoiceMail extends Mailable
{
    public $invoiceData;

    public function __construct($invoiceData)
    {
        $this->invoiceData = $invoiceData;
    }

    public function build()
    {
        return $this->subject('Invoice Details')
                    ->view('emails.invoice');
    }
}
```

---

# ✅ 4. Create Invoice Blade View

`resources/views/emails/invoice.blade.php`

```html
<h2>Invoice</h2>

<p><strong>Customer:</strong> {{ $invoiceData['name'] }}</p>
<p><strong>Amount:</strong> ₹{{ $invoiceData['amount'] }}</p>
<p><strong>Date:</strong> {{ $invoiceData['date'] }}</p>

<hr>

<p><strong>Bank Details:</strong></p>
<p>
Bank: Bank of Baroda<br>
Account No: 12345<br>
IFSC: BOB67890
</p>
```

---

# ✅ 5. Send Email (Controller / Command)

### Example in Controller:

```php
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

public function sendInvoice()
{
    $data = [
        'name' => 'Prabhu',
        'amount' => 5000,
        'date' => now()->format('d-m-Y'),
    ];

    Mail::to('bughunt321@gmail.com')->send(new InvoiceMail($data));

    return "Invoice Sent!";
}
```

---

# ✅ 6. Configure Mailtrap SMTP (EASIEST WAY)

Instead of API SDK, Laravel works **best with SMTP**

### In `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@bughunt.in
MAIL_FROM_NAME="Invoice App"
```

👉 Get these from Mailtrap Inbox → SMTP Settings

---

# ✅ 7. Run

```bash
php artisan serve
```

Call your route → email will appear in Mailtrap inbox

---

# 🎯 BONUS: Send PDF Invoice (Advanced)

Install DOMPDF:

```bash
composer require barryvdh/laravel-dompdf
```

Then attach PDF:

```php
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('pdf.invoice', $data);

return $this->subject('Invoice')
    ->view('emails.invoice')
    ->attachData($pdf->output(), 'invoice.pdf');
```

---

# 🚀 Summary

* Use **Mailable (best practice)**
* Use **SMTP instead of API**
* Create Blade invoice template
* Optional → attach PDF

---

If you want, I can generate a **professional invoice design (like GST invoice with table, logo, totals)** ready for PDF 👍

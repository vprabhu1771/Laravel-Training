```
https://packagist.org/packages/laraveldaily/laravel-invoices
```

Since you are using Laravel Laravel 12.58.0, `aroutinr/laravel-invoice` is incompatible because it only supports up to Laravel 10.

The best solution is to use a Laravel 12 compatible invoice package.

## Recommended Package

Use:

```bash id="kr51ns"
composer require laraveldaily/laravel-invoices
```

---

# Complete Laravel 12 Invoice Example

## 1. Publish Config

```bash id="jlwmkh"
php artisan vendor:publish --provider="LaravelDaily\Invoices\InvoicesServiceProvider"
```

---

# 2. Create Controller

```bash id="k3k6bo"
php artisan make:controller InvoiceController
```

---

# 3. Invoice Controller Example

`app/Http/Controllers/InvoiceController.php`

```php id="1cn1jr"
<?php

namespace App\Http\Controllers;

use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    public function index()
    {
        $customer = new Buyer([
            'name'          => 'Prabhu Kumar',
            'custom_fields' => [
                'email' => 'prabhu@example.com',
                'phone' => '9876543210',
                'GSTIN' => '33ABCDE1234F1Z5',
            ],
        ]);

        $items = [
            InvoiceItem::make('Premium Mattress')
                ->pricePerUnit(12000)
                ->quantity(1),

            InvoiceItem::make('Pillow')
                ->pricePerUnit(1500)
                ->quantity(2),

            InvoiceItem::make('Bedsheet')
                ->pricePerUnit(2000)
                ->quantity(1),
        ];

        $invoice = Invoice::make('INV-2026-0001')
            ->buyer($customer)
            ->taxRate(18)
            ->addItems($items)
            ->notes('Thank you for your purchase!')
            ->logo(public_path('logo.png'));

        return $invoice->stream();
    }
}
```

---

# 4. Add Route

`routes/web.php`

```php id="zocczw"
use App\Http\Controllers\InvoiceController;

Route::get('/invoice', [InvoiceController::class, 'index']);
```

---

# 5. Open Invoice

```bash id="n3p43j"
http://127.0.0.1:8000/invoice
```

---

# Download PDF Instead of Stream

```php id="i0mz7z"
return $invoice->download();
```

---

# Save PDF

```php id="y3a59x"
$invoice->save('public');

return response()->json([
    'message' => 'Invoice Saved'
]);
```

---

# Dynamic Product Loop Example

```php id="11yax7"
$invoice = Invoice::make();

foreach ($products as $product) {

    $invoice->addItem(
        InvoiceItem::make($product->name)
            ->pricePerUnit($product->price)
            ->quantity($product->qty)
    );
}
```

---

# Tamil Nadu GST Example

## TN → TN

* CGST 9%
* SGST 9%

```php id="ws2hkr"
->taxRate(18)
```

---

# TN → Karnataka / Kerala

* IGST 18%

```php id="v2r9xz"
->taxRate(18)
```

You can dynamically calculate based on state.

---

# Add Company Details

`config/invoices.php`

```php id="x1bh9u"
'vendor' => [
    'class' => \LaravelDaily\Invoices\Classes\Seller::class,

    'attributes' => [
        'name' => 'KingFlex Mattress',
        'address' => 'Chennai, Tamil Nadu',
        'phone' => '9876543210',
        'email' => 'sales@kingflexmattress.com',
    ],
],
```

---

# Email Invoice

```php id="jlwmvb"
Mail::to($customerEmail)->send(new InvoiceMail($invoice));
```

---

# Features

✅ Laravel 12 Compatible
✅ PDF Invoice
✅ GST Support
✅ Dynamic Products
✅ Company Logo
✅ Download / Stream
✅ Email Invoice
✅ Tax Calculation
✅ Custom Notes
✅ Professional Layout

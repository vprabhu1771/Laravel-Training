For Tamil Nadu → Tamil Nadu billing, you should split GST into:

* CGST = 9%
* SGST = 9%

Instead of a single 18% GST line.

Here’s the updated Laravel 12 invoice example using Laravel compatible package.

```php id="xq3b8s"
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    public function index()
    {
        // Customer
        $customer = new Buyer([
            'name' => 'Prabhu Kumar',

            'custom_fields' => [
                'Email'  => 'prabhu@example.com',
                'Phone'  => '9876543210',
                'GSTIN'  => '33ABCDE1234F1Z5',
                'State'  => 'Tamil Nadu',
            ],
        ]);

        // Products
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

        // Sub Total
        $subtotal = 0;

        foreach ($items as $item) {

            $subtotal += $item->price_per_unit * $item->quantity;
        }

        // Tamil Nadu GST
        $cgst = ($subtotal * 9) / 100;
        $sgst = ($subtotal * 9) / 100;

        // Total GST
        $gstTotal = $cgst + $sgst;

        // Final Total
        $grandTotal = $subtotal + $gstTotal;

        // Invoice
        $invoice = Invoice::make('INV-2026-0001')

            ->buyer($customer)

            ->addItems($items)

            ->taxRate(0)

            ->notes(
                "CGST (9%) : ₹" . number_format($cgst, 2) . "\n" .
                "SGST (9%) : ₹" . number_format($sgst, 2) . "\n" .
                "Total GST : ₹" . number_format($gstTotal, 2) . "\n" .
                "Grand Total : ₹" . number_format($grandTotal, 2)
            );

        return $invoice->stream();
    }
}
```

# GST Calculation

| Tax Type  | Percentage |
| --------- | ---------- |
| CGST      | 9%         |
| SGST      | 9%         |
| Total GST | 18%        |

---

# Example Output

| Description | Amount  |
| ----------- | ------- |
| Subtotal    | ₹17,000 |
| CGST 9%     | ₹1,530  |
| SGST 9%     | ₹1,530  |
| Grand Total | ₹20,060 |

---

# TN → Karnataka / Kerala

For interstate billing:

* Use IGST 18%
* No CGST/SGST split

Example:

```php id="l5v53x"
$igst = ($subtotal * 18) / 100;
```

---

# Dynamic GST Logic

```php id="w7j1j2"
if ($seller_state == $customer_state) {

    // CGST + SGST

} else {

    // IGST
}
```

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Customer State
        |--------------------------------------------------------------------------
        | Example:
        | Tamil Nadu      => TN
        | Karnataka       => KA
        | Kerala          => KL
        */

        $customerState = 'KA'; // Change dynamically

        /*
        |--------------------------------------------------------------------------
        | Seller State
        |--------------------------------------------------------------------------
        */

        $sellerState = 'TN';

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Sub Total Calculation
        |--------------------------------------------------------------------------
        */

        $subtotal = 0;

        foreach ($items as $item) {

            $subtotal +=
                $item->price_per_unit *
                $item->quantity;
        }

        /*
        |--------------------------------------------------------------------------
        | GST Calculation
        |--------------------------------------------------------------------------
        */

        $cgst = 0;
        $sgst = 0;
        $igst = 0;

        /*
        |--------------------------------------------------------------------------
        | TN -> TN
        |--------------------------------------------------------------------------
        | CGST 9%
        | SGST 9%
        */

        if ($sellerState == $customerState) {

            $cgst = ($subtotal * 9) / 100;
            $sgst = ($subtotal * 9) / 100;
        }

        /*
        |--------------------------------------------------------------------------
        | TN -> Other State
        |--------------------------------------------------------------------------
        | IGST 18%
        */

        else {

            $igst = ($subtotal * 18) / 100;
        }

        /*
        |--------------------------------------------------------------------------
        | Grand Total
        |--------------------------------------------------------------------------
        */

        $grandTotal =
            $subtotal +
            $cgst +
            $sgst +
            $igst;

        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

        $customer = new Buyer([
            'name' => 'Prabhu Kumar',

            'custom_fields' => [
                'email' => 'prabhu@example.com',
                'phone' => '9876543210',
                'GSTIN' => '33ABCDE1234F1Z5',
                'State' => $customerState,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Invoice
        |--------------------------------------------------------------------------
        */

        $invoice = Invoice::make('INV-2026-0001')
            ->buyer($customer)
            ->addItems($items)

            ->notes(
                'Subtotal : ₹' . number_format($subtotal, 2) . PHP_EOL .

                'CGST 9% : ₹' . number_format($cgst, 2) . PHP_EOL .

                'SGST 9% : ₹' . number_format($sgst, 2) . PHP_EOL .

                'IGST 18% : ₹' . number_format($igst, 2) . PHP_EOL .

                'Grand Total : ₹' . number_format($grandTotal, 2)
            );

        return $invoice->stream();
    }
}
```

# GST Logic

| Condition      | Tax Type          |
| -------------- | ----------------- |
| TN → TN        | CGST 9% + SGST 9% |
| TN → Karnataka | IGST 18%          |
| TN → Kerala    | IGST 18%          |

# State Codes

| State          | Code |
| -------------- | ---- |
| Tamil Nadu     | TN   |
| Karnataka      | KA   |
| Kerala         | KL   |
| Andhra Pradesh | AP   |
| Telangana      | TS   |

# Dynamic Database Example

```php
$customerState = $order->state_code;
```

OR

```php
$customerState = $customer->state;
```

# Optional Auto GST Method

```php
private function calculateGST($subtotal, $sellerState, $customerState)
{
    if ($sellerState == $customerState) {

        return [
            'cgst' => ($subtotal * 9) / 100,
            'sgst' => ($subtotal * 9) / 100,
            'igst' => 0,
        ];
    }

    return [
        'cgst' => 0,
        'sgst' => 0,
        'igst' => ($subtotal * 18) / 100,
    ];
}
```

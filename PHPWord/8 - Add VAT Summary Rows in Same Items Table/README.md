Perfect 👍
You want **VAT 15%**, show:

1. **Subtotal**
2. **VAT (15%) amount**
3. **Grand Total (Including VAT)**

**Below the quotation items table**.

---

## ✅ Best Practice: Add VAT Summary Rows in Same Items Table

Update your **`addQuotationItemsTable()`** like this 👇

---

## ✨ Updated `addQuotationItemsTable()` with VAT 15%

```php
private function addQuotationItemsTable(
    PhpWord $phpWord,
    Section $section,
    Quotation $quotation
) {
    $section->addTextBreak(1);

    $tableStyle = [
        'borderSize' => 6,
        'borderColor' => '000000',
        'cellMargin' => 80,
    ];

    $firstRowStyle = ['bgColor' => 'EAEAEA'];

    $phpWord->addTableStyle('QuotationItemsTable', $tableStyle, $firstRowStyle);

    $table = $section->addTable('QuotationItemsTable');

    // Header
    $table->addRow();
    $table->addCell(800)->addText('S.No', ['bold' => true]);
    $table->addCell(3000)->addText('Item Name', ['bold' => true]);
    $table->addCell(1200)->addText('Qty', ['bold' => true]);
    $table->addCell(1800)->addText('Unit Price', ['bold' => true]);
    $table->addCell(1800)->addText('Amount', ['bold' => true]);

    $subTotal = 0;
    $sno = 1;

    foreach ($quotation->items as $item) {
        $amount = $item->qty * $item->unit_price;
        $subTotal += $amount;

        $table->addRow();
        $table->addCell()->addText($sno++);
        $table->addCell()->addText($item->name);
        $table->addCell()->addText($item->qty);
        $table->addCell()->addText(number_format($item->unit_price, 2));
        $table->addCell()->addText(number_format($amount, 2));
    }

    // VAT calculation
    $vatRate = 15;
    $vatAmount = ($subTotal * $vatRate) / 100;
    $grandTotal = $subTotal + $vatAmount;

    // Subtotal row
    $table->addRow();
    $table->addCell(null, ['gridSpan' => 4])
        ->addText('Subtotal', ['bold' => true]);
    $table->addCell()
        ->addText(number_format($subTotal, 2), ['bold' => true]);

    // VAT row
    $table->addRow();
    $table->addCell(null, ['gridSpan' => 4])
        ->addText("VAT ({$vatRate}%)", ['bold' => true]);
    $table->addCell()
        ->addText(number_format($vatAmount, 2), ['bold' => true]);

    // Grand total row
    $table->addRow();
    $table->addCell(null, ['gridSpan' => 4])
        ->addText('Total Amount (Including VAT)', ['bold' => true]);
    $table->addCell()
        ->addText(number_format($grandTotal, 2), ['bold' => true]);
}
```

---

## 📄 Word Output (Below Items)

```
Subtotal                         100,000.00
VAT (15%)                         15,000.00
Total Amount (Including VAT)     115,000.00
```

---

## 🔥 Optional Enhancements

I can also add:

* VAT rate from DB
* Currency symbol (₹ / SAR / $)
* Amount in words
* Separate **summary table** instead of rows
* Bold border only for total rows

Tell me what you want next 🚀

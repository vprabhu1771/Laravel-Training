To **format `quote_date` properly**, you should convert it to a **Carbon date** before printing.

Here are the **correct & safe ways** 👇

---

## ✅ Best Practice (Carbon / Laravel Way)

```php
use Carbon\Carbon;

$table->addCell(6000)->addText(
    'Date: ' . Carbon::parse($quotation->quote_date)->format('d-m-Y')
);
```

---

## ✅ If `quote_date` Is Already a Date Cast (Recommended)

### Model (`Quotation.php`)

```php
protected $casts = [
    'quote_date' => 'date',
];
```

### Then simply:

```php
$table->addCell(6000)->addText(
    'Date: ' . $quotation->quote_date->format('d-m-Y')
);
```

---

## ✅ Null-Safe Version (Avoid Errors)

```php
$table->addCell(6000)->addText(
    'Date: ' . optional($quotation->quote_date)->format('d-m-Y')
);
```

---

## 📌 Output Example

```
Date: 14-01-2026
```

---

## 🔥 Pro Tip

For Indian quotation format, you can also use:

```php
->format('d M Y') // 14 Jan 2026
```

---

If you want:

* Automatic date formatting everywhere
* Financial year-based quotation dates
* Locale-based formatting

Just tell me 👍

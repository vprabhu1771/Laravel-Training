Below is a **clean, working PHPWord implementation** inside your `QuotationController` that exports **quotation items into a table** with:

**S.No | Name | Qty | Unit Price | Total**

---

## 1️⃣ Install PHPWord (if not installed)

```bash
composer require phpoffice/phpword
```

---

## 2️⃣ QuotationController Implementation

```php
<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class QuotationController extends Controller
{
    public function exportWord($id)
    {
        $quotation = Quotation::with('items')->findOrFail($id);

        $phpWord = new PhpWord();

        $section = $phpWord->addSection();

        // Title
        $section->addText(
            'Quotation',
            ['bold' => true, 'size' => 16],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);

        // Table style
        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
        ];

        $firstRowStyle = ['bgColor' => 'EAEAEA'];

        $phpWord->addTableStyle('QuotationTable', $tableStyle, $firstRowStyle);

        $table = $section->addTable('QuotationTable');

        // Header row
        $table->addRow();
        $table->addCell(800)->addText('S.No', ['bold' => true]);
        $table->addCell(3000)->addText('Item Name', ['bold' => true]);
        $table->addCell(1200)->addText('Qty', ['bold' => true]);
        $table->addCell(1800)->addText('Unit Price', ['bold' => true]);
        $table->addCell(1800)->addText('Total', ['bold' => true]);

        // Items
        $grandTotal = 0;
        $sno = 1;

        foreach ($quotation->items as $item) {
            $total = $item->qty * $item->unit_price;
            $grandTotal += $total;

            $table->addRow();
            $table->addCell()->addText($sno++);
            $table->addCell()->addText($item->name);
            $table->addCell()->addText($item->qty);
            $table->addCell()->addText(number_format($item->unit_price, 2));
            $table->addCell()->addText(number_format($total, 2));
        }

        // Grand total row
        $table->addRow();
        $table->addCell(null, ['gridSpan' => 4])
              ->addText('Grand Total', ['bold' => true]);
        $table->addCell()->addText(number_format($grandTotal, 2), ['bold' => true]);

        // Save file
        $fileName = 'quotation_' . $quotation->id . '.docx';
        $path = storage_path($fileName);

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
```

---

## 3️⃣ Route
Just add a **route name** using `->name()` 👇

```php
Route::get('/quotation/{id}/word', [QuotationController::class, 'exportWord'])->name('quotation.export.word');
```

---

## ✅ How to Use the Named Route

### Blade

```blade
<a href="{{ route('quotation.export.word', $quotation->id) }}" class="btn btn-primary">
    Export Word
</a>
```

### Controller / Redirect

```php
return redirect()->route('quotation.export.word', $quotation->id);
```

### Filament Button

```php
Actions\Action::make('exportWord')
    ->label('Export Word')
    ->url(fn ($record) => route('quotation.export.word', $record->id))
    ->openUrlInNewTab();
```

---

## 📌 Route List Check

```bash
php artisan route:list | grep quotation
```

You’ll see:

```
quotation.export.word
```

---

## 4️⃣ Output Table (Word)

| S.No | Item Name       | Qty | Unit Price |     Total |
| ---: | --------------- | --: | ---------: | --------: |
|    1 | Laptop          |   2 |      45000 |     90000 |
|    2 | Mouse           |   5 |        500 |      2500 |
|      | **Grand Total** |     |            | **92500** |

---

## 🔥 Optional Enhancements

If you want next:

* ✅ Company header + logo
* ✅ Tax / GST rows
* ✅ PDF + Word export switch
* ✅ Filament button integration
* ✅ Currency formatting (₹)

Tell me and I’ll add it cleanly 💡



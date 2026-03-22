Good question 👍
Right now everything is inside `exportWord()`.
You want **Quotation Items in a separate table function** (clean & reusable).

Below is the **proper refactor**.

---

## ✅ 1️⃣ Create a Separate Function for Quotation Items Table

Add this **inside `QuotationController`**:

```php
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Section;
use App\Models\Quotation;

private function addQuotationItemsTable(
    PhpWord $phpWord,
    Section $section,
    Quotation $quotation
) {
    // Space before items table
    $section->addTextBreak(1);

    // Table style
    $tableStyle = [
        'borderSize' => 6,
        'borderColor' => '000000',
        'cellMargin' => 80,
    ];

    $firstRowStyle = ['bgColor' => 'EAEAEA'];

    $phpWord->addTableStyle('QuotationItemsTable', $tableStyle, $firstRowStyle);

    $table = $section->addTable('QuotationItemsTable');

    // Header row
    $table->addRow();
    $table->addCell(800)->addText('S.No', ['bold' => true]);
    $table->addCell(3000)->addText('Item Name', ['bold' => true]);
    $table->addCell(1200)->addText('Qty', ['bold' => true]);
    $table->addCell(1800)->addText('Unit Price', ['bold' => true]);
    $table->addCell(1800)->addText('Amount', ['bold' => true]);

    $grandTotal = 0;
    $sno = 1;

    foreach ($quotation->items as $item) {
        $amount = $item->qty * $item->unit_price;
        $grandTotal += $amount;

        $table->addRow();
        $table->addCell()->addText($sno++);
        $table->addCell()->addText($item->name);
        $table->addCell()->addText($item->qty);
        $table->addCell()->addText(number_format($item->unit_price, 2));
        $table->addCell()->addText(number_format($amount, 2));
    }

    // Total row
    $table->addRow();
    $table->addCell(null, ['gridSpan' => 4])
        ->addText('Total', ['bold' => true]);
    $table->addCell()
        ->addText(number_format($grandTotal, 2), ['bold' => true]);
}
```

---

## ✅ 2️⃣ Clean `exportWord()` (Much Better)

Now your `exportWord()` becomes **simple & readable**:

```php
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

    // Greeting
    $section->addText('Dear Sir,', ['bold' => true, 'size' => 12]);
    $section->addText(
        'Greetings from JABAL HEMALAYA FOR INSPECTION!!',
        ['size' => 12]
    );

    // Company info table
    $this->addCompanyInformationTable($phpWord, $section, $quotation);

    // Intro text
    $section->addText(
        'We are pleased to quote our best offer for the following:',
        ['bold' => true, 'size' => 12]
    );

    // ✅ Quotation items table (separate function)
    $this->addQuotationItemsTable($phpWord, $section, $quotation);

    // Save file
    $fileName = 'quotation_' . $quotation->id . '.docx';
    $directory = 'quotations';

    Storage::makeDirectory($directory);

    $path = storage_path('app/' . $directory . '/' . $fileName);

    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($path);

    return response()->download($path)->deleteFileAfterSend(true);
}
```

---

## 📄 Final Word Layout

```
Quotation

Dear Sir,
Greetings from JABAL HEMALAYA FOR INSPECTION!!

[Company Information Table]

We are pleased to quote our best offer for the following:

[Quotation Items Table]
----------------------------------
| S.No | Item | Qty | Price | Amt |
----------------------------------
| 1    | Test | 2   | 500   | 1000|
----------------------------------
|            Total              1000
```

---

## 🔥 Why This Is Professional

✅ Controller stays clean
✅ Easy to maintain
✅ Same table usable for PDF later
✅ Easy to add GST / Tax table next

---

If you want next:

* GST + Net Total table
* Amount in words
* Signature & seal section
* Same layout for **mPDF**

Just say the word 🚀

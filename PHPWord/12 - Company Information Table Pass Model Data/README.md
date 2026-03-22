You need to **pass a model/object (e.g. `$quotation`) into the function** and then **read values from it** instead of hard-coding text.

Below is the **correct, clean solution** 👇

---

## ✅ Step 1: Update Function Signature (Accept Data)

Pass the **Quotation model** (or company object):

```php
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Section;
use App\Models\Quotation;

private function addCompanyInformationTable(
    PhpWord $phpWord,
    Section $section,
    Quotation $quotation
) {
```

---

## ✅ Step 2: Use Dynamic Values (`$quotation->company_name`)

```php
    // Space before table
    $section->addTextBreak(2);

    $tableStyle = [
        'borderSize' => 6,
        'borderColor' => '000000',
        'cellMargin' => 80,
    ];

    $phpWord->addTableStyle('CompanyInfoTable', $tableStyle);

    $table = $section->addTable('CompanyInfoTable');

    // Row 1
    $table->addRow();
    $table->addCell(4000)->addText(
        'Company Name: ' . $quotation->company_name,
        ['bold' => true]
    );
    $table->addCell(6000)->addText(
        'Date: ' . optional($quotation->quote_date)->format('d-m-Y')
    );

    // Row 2
    $table->addRow();
    $table->addCell(4000)->addText(
        'Company Representative: ' . ($quotation->salesPerson->name ?? '—'),
        ['bold' => true]
    );
    $table->addCell(6000)->addText(
        'Quotation No: ' . $quotation->quote_number
    );

    // Row 3
    $table->addRow();
    $table->addCell(4000)->addText(
        'Designation: ' . ($quotation->designation ?? ''),
        ['bold' => true]
    );
    $table->addCell(6000)->addText(
        'Customer Ref: ' . ($quotation->customer_ref ?? '')
    );

    // Row 4
    $table->addRow();
    $table->addCell(4000)->addText(
        'Address: ' . ($quotation->address ?? ''),
        ['bold' => true]
    );
    $table->addCell(6000)->addText(
        'Mobile: ' . ($quotation->mobile ?? '')
    );

    // Row 5
    $table->addRow();
    $table->addCell(4000)->addText(
        'Contact No./Email: ' . ($quotation->email ?? ''),
        ['bold' => true]
    );
    $table->addCell(6000)->addText(
        'Contact Person: ' . ($quotation->contact_person ?? '')
    );

    // Row 6
    $table->addRow();
    $table->addCell(4000)->addText(
        'Project: ' . ($quotation->project ?? ''),
        ['bold' => true]
    );
    $table->addCell(6000)->addText('');
```

---

## ✅ Step 3: Call the Function Correctly

Inside `exportWord()`:

```php
$quotation = Quotation::with('salesPerson')->findOrFail($id);

// Greeting text above
$section->addTextBreak(2);
$section->addText('Dear Sir,', ['bold' => true]);
$section->addTextBreak(1);
$section->addText('Greetings from JABAL HEMALAYA FOR INSPECTION!!');

// ✅ Pass quotation row
$this->addCompanyInformationTable($phpWord, $section, $quotation);
```

---

## 📌 Result (Dynamic Word Output)

```
Company Name: JABAL HEMALAYA     Date: 14-01-2026
Company Representative: KK     Quotation No: QTN-001
Designation: Manager           Customer Ref: ABC
Address: Chennai               Mobile: 9876543210
Contact No./Email: x@y.com     Contact Person: Ravi
Project: Inspection Project
```

---

## 🔥 Pro Tip (Cleaner)

If you want **even cleaner code**, I can:

* Move this to a `QuotationWordService`
* Map rows using an array loop
* Reuse the same layout for **PDF & Word**

Just tell me 🚀

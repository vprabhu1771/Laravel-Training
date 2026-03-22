Perfect 👍
Below is a **clean, reusable approach**:
➡️ Move the **company information table** into a **separate function** and call it where needed.

---

## ✅ Step 1: Create a Separate Function for Company Information Table

Add this **inside `QuotationController`**:

```php
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Section;

private function addCompanyInformationTable(PhpWord $phpWord, Section $section)
{
    // Space before table
    $section->addTextBreak(2);

    // Table style
    $tableStyle = [
        'borderSize' => 6,
        'borderColor' => '000000',
        'cellMargin' => 80,
    ];

    $phpWord->addTableStyle('CompanyInfoTable', $tableStyle);

    $table = $section->addTable('CompanyInfoTable');

    // Row 1
    $table->addRow();
    $table->addCell(4000)->addText('Company Name', ['bold' => true]);
    $table->addCell(6000)->addText('JABAL HEMALAYA');

    // Row 2
    $table->addRow();
    $table->addCell(4000)->addText('Inspection Location', ['bold' => true]);
    $table->addCell(6000)->addText('JABAL HEMALAYA FOR INSPECTION');

    // Row 3
    $table->addRow();
    $table->addCell(4000)->addText('Inspection Date', ['bold' => true]);
    $table->addCell(6000)->addText(date('d-m-Y'));

    // Row 4
    $table->addRow();
    $table->addCell(4000)->addText('Prepared By', ['bold' => true]);
    $table->addCell(6000)->addText('JABAL HEMALAYA TEAM');
}
```

---

## ✅ Step 2: Call This Function in `exportWord()`

Place this **after greeting text** 👇

```php
// Greeting
$section->addTextBreak(2);
$section->addText('Dear Sir,', ['bold' => true]);
$section->addTextBreak(1);
$section->addText('Greetings from JABAL HEMALAYA FOR INSPECTION!!');

// 👉 Call Company Information Table
$this->addCompanyInformationTable($phpWord, $section);
```

---

## 📄 Final Word Document Flow

```
Quotation Items Table

Dear Sir,

Greetings from JABAL HEMALAYA FOR INSPECTION!!

------------------------------------------
| Company Name        | JABAL HEMALAYA    |
| Inspection Location | JABAL HEMALAYA... |
| Inspection Date     | 14-01-2026        |
| Prepared By         | Team              |
------------------------------------------
```

---

## 🔥 Why This Is Best Practice

✅ Clean controller
✅ Reusable table
✅ Easy to modify later
✅ Perfect for adding GST / Bank / Signature tables next

---

### Want next?

* Dynamic company data from DB
* Multiple info tables (Bank, Terms, Signature)
* Reusable **WordExportService**
* Same layout for **PDF + Word**

Just tell me 🚀

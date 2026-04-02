Got it 👍
You want **PDF generation using PHPWord itself** (not mPDF), via **`savePDF()`**.

PHPWord supports PDF **only through external renderers** (DomPDF / TCPDF / mPDF).
Below is the **correct, clean, production-ready way**.

---

## ✅ 1️⃣ Install PDF Renderer (Recommended: DomPDF)

```bash
composer require dompdf/dompdf
```

---

## ✅ 2️⃣ Configure PHPWord PDF Renderer (IMPORTANT)

Add this **once** (controller constructor or AppServiceProvider):

```php
use PhpOffice\PhpWord\Settings;

Settings::setPdfRenderer(
    Settings::PDF_RENDERER_DOMPDF,
    base_path('vendor/dompdf/dompdf')
);
```

# OR

```php
use PhpOffice\PhpWord\Settings;

class QuotationController extends Controller
{

    function __construct() {
        Settings::setPdfRenderer(
            Settings::PDF_RENDERER_DOMPDF,
            base_path('vendor/dompdf/dompdf')
        );
    }
}
```

⚠️ Without this, `savePDF()` **will NOT work**.

---

## ✅ 3️⃣ Create `saveAndDownloadPDF()` using PHPWord

```php
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;

private function saveAndDownloadPDF(
    \PhpOffice\PhpWord\PhpWord $phpWord,
    string $fileName,
    string $directory = 'quotations'
) {
    // Create directory if not exists
    Storage::makeDirectory($directory);

    // Full path
    $path = storage_path('app/' . $directory . '/' . $fileName);

    // Create PDF writer
    $writer = IOFactory::createWriter($phpWord, 'PDF');

    // Save PDF
    $writer->save($path);

    // Download and delete after send
    return response()->download($path)->deleteFileAfterSend(true);
}
```

---

## ✅ 4️⃣ How to Call It

```php
$fileName = 'quotation_' . $quotation->id . '.pdf';

return $this->saveAndDownloadPDF($phpWord, $fileName);
```

---

## ✅ 5️⃣ Your Existing Word Function (For Consistency)

```php
private function saveAndDownloadWord(
    \PhpOffice\PhpWord\PhpWord $phpWord,
    string $fileName,
    string $directory = 'quotations'
) {
    Storage::makeDirectory($directory);

    $path = storage_path('app/' . $directory . '/' . $fileName);

    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($path);

    return response()->download($path)->deleteFileAfterSend(true);
}
```

---

## ⚠️ Important PHPWord PDF Limitations (Be aware)

❌ Complex tables may break
❌ CSS is limited
❌ Fonts may not render perfectly

👉 **Best use case:**
✔ Invoices
✔ Quotations
✔ Reports
✔ Simple layouts

If you want **pixel-perfect PDFs**, mPDF is still better — but **this is the correct PHPWord way**.

---

## 🚀 Want Next?

* VAT + total table aligned properly in PDF
* Page footer (Prepared by / Signature)
* Logo header
* Currency formatting helper
* Switch Word / PDF with single export method

Just tell me 👍

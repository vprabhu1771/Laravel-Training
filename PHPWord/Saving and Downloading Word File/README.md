Perfect 👍
Move **all file save + download logic** into **one reusable function**.

Below is the **clean, professional refactor**.

---

## ✅ 1️⃣ Create a Separate Function for Saving & Downloading Word File

Add this **inside `QuotationController`**:

```php
private function saveAndDownloadWord(
    PhpWord $phpWord,
    string $fileName,
    string $directory = 'quotations'
) {
    // Create directory if not exists
    Storage::makeDirectory($directory);

    // Full path
    $path = storage_path('app/' . $directory . '/' . $fileName);

    // Save Word file
    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($path);

    // Download and delete after send
    return response()->download($path)->deleteFileAfterSend(true);
}
```

---

## ✅ 2️⃣ Update `exportWord()` (Clean & Short)

Replace the bottom part of `exportWord()` with:

```php
$fileName = 'quotation_' . $quotation->id . '.docx';

return $this->saveAndDownloadWord($phpWord, $fileName);
```

---

## 📌 Final Flow

```php
$this->addCompanyInformationTable(...);
$this->addQuotationItemsTable(...);

$fileName = 'quotation_' . $quotation->id . '.docx';

return $this->saveAndDownloadWord($phpWord, $fileName);
```

---

## 🔥 Benefits

✔ No duplicated logic
✔ Easy to change folder later
✔ Reusable for invoices, reports
✔ Cleaner controller

---

## 🚀 Optional Improvements

If you want:

* Save permanently (no delete)
* Dynamic folder per year/month
* Store file path in DB
* Word + PDF switch in one function

Just tell me 👌

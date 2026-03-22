Good idea 👍
Create a **separate reusable function** just for the **header image (logo)** and call it inside your header setup.

Below is the **clean & correct implementation**.

---

## ✅ 1️⃣ Header Image Function

Add this **inside `QuotationController`**:

```php
use PhpOffice\PhpWord\Element\Section;

private function HeaderImage(
    Section $section,
    string $imagePath,
    int $width = 80
) {
    $header = $section->addHeader();

    // Add logo image
    $header->addImage(
        $imagePath,
        [
            'width' => $width,
            'alignment' => 'center',
        ]
    );
}
```

---

## ✅ 2️⃣ Update Your Existing Header Function (Text)

Keep your **text header** function as-is, or slightly improved:

```php
private function HeaderText(
    Section $section
) {
    $header = $section->addHeader();

    $header->addText(
        'JABAL HEMALAYA',
        ['bold' => true, 'size' => 12],
        ['alignment' => 'center']
    );

    $header->addText(
        'Quotation',
        ['size' => 10],
        ['alignment' => 'center']
    );
}
```

---

## ⚠️ Important PHPWord Rule

> Calling `$section->addHeader()` **multiple times overrides the previous header**.

So **DO NOT** call both functions separately like this ❌:

```php
$this->HeaderImage($section, $path);
$this->HeaderText($section); // overrides image ❌
```

---

## ✅ 3️⃣ Correct Way: Combine Image + Text in ONE Header

### ✔ Best Practice (Single Header Builder)

```php
private function buildHeader(
    Section $section,
    string $imagePath
) {
    $header = $section->addHeader();

    // Logo
    $header->addImage(
        $imagePath,
        [
            'width' => 80,
            'alignment' => 'center',
        ]
    );

    // Space
    $header->addTextBreak(1);

    // Company name
    $header->addText(
        'JABAL HEMALAYA',
        ['bold' => true, 'size' => 12],
        ['alignment' => 'center']
    );

    // Document title
    $header->addText(
        'Quotation',
        ['size' => 10],
        ['alignment' => 'center']
    );
}
```

---

## ✅ 4️⃣ Call It in `exportWord()`

```php
$section = $phpWord->addSection();

// Header with image + text
$this->buildHeader(
    $section,
    public_path('images/logo.png') // adjust path
);
```

---

## 📂 Image Path Tips

Best options:

```php
public_path('images/logo.png')
storage_path('app/public/logo.png')
```

If using storage:

```bash
php artisan storage:link
```

---

## 🔥 Result

✔ Logo centered
✔ Company name below logo
✔ Quotation title below
✔ Appears on every page

---

### Want more?

* Different header for first page
* Left logo + right company info
* Watermark logo
* Footer logo + signature

Tell me 🚀

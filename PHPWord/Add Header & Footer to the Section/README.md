You’re almost there 👌
PHPWord supports **page headers & footers** natively.
Below is the **correct and clean way** to add:

* ✅ **Header** (company name / quotation title)
* ✅ **Footer** with **Page X** (Page 1, Page 2…)

---

## ✅ 1️⃣ Add Header & Footer to the Section

Update this part inside **`exportWord()`**, **after**:

```php
$section = $phpWord->addSection();
```

---

### 🔹 Header (Top of Every Page)

```php
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
```

---

### 🔹 Footer with Page Number

```php
$footer = $section->addFooter();

// Page X (auto increment)
$footer->addPreserveText(
    'Page {PAGE}',
    ['size' => 9],
    ['alignment' => 'center']
);
```

---

## ✅ 2️⃣ If You Want "Page X of Y"

PHPWord also supports total pages:

```php
$footer->addPreserveText(
    'Page {PAGE} of {NUMPAGES}',
    ['size' => 9],
    ['alignment' => 'center']
);
```

---

## 📄 Final Word Output

### Header

```
JABAL HEMALAYA
Quotation
```

### Footer

```
Page 1
```

or

```
Page 1 of 3
```

---

## ✅ 3️⃣ Optional Enhancements (Professional Touch)

### Left-aligned footer + right-aligned date

```php
$footerTable = $footer->addTable();

$footerTable->addRow();
$footerTable->addCell(5000)->addPreserveText(
    'Page {PAGE}',
    ['size' => 9]
);

$footerTable->addCell(5000)->addText(
    'Generated on: ' . now()->format('d-m-Y'),
    ['size' => 9],
    ['alignment' => 'right']
);
```

---

## 🔥 Pro Tips

* Header/footer applies to **all pages**
* `{PAGE}` updates automatically
* Works perfectly with **multi-page tables**
* Same logic works for **PDF later**

---

If you want next:

* Different header for first page
* Company logo in header
* Signature only on last page
* Convert same layout to **mPDF**

Just tell me 🚀

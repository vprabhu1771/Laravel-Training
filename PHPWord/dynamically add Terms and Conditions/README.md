To add **another page for “Terms & Conditions”** when using **PhpWord `TemplateProcessor`**, you have **two clean options**.
Because `TemplateProcessor` **cannot dynamically add sections**, the **page break must exist in the DOCX template**.

---

## ✅ **RECOMMENDED (Clean & Safe): Use a Page Break Placeholder in Template**

### **Step 1: Edit `template.docx`**

At the **end of your quotation content**, add:

```
${page_break}
Terms & Conditions

1. Prices are valid for 30 days.
2. Payment should be made within 15 days.
3. GST/VAT as applicable.
4. Delivery timeline will be confirmed after order.
```

👉 Make sure **Terms & Conditions is on a new page** visually in Word.

---

### **Step 2: Add Page Break in Controller**

Use **Word XML page break**:

```php
/* -------------------------
TERMS & CONDITIONS PAGE
--------------------------*/
$template->setValue(
    'page_break',
    '</w:t></w:r><w:r><w:br w:type="page"/></w:r><w:r><w:t>'
);
```

That’s it ✅
When the file downloads, **Terms & Conditions will be on Page 2**.

---

## ✅ **OPTION 2: Dynamic Terms from Database**

If you want **editable terms from DB**:

### **Template**

```
${page_break}
${terms_conditions}
```

### **Controller**

```php
$template->setValue(
    'page_break',
    '</w:t></w:r><w:r><w:br w:type="page"/></w:r><w:r><w:t>'
);

$template->setValue(
    'terms_conditions',
    nl2br(e($quotation->terms_conditions))
);
```

---

## ❌ What NOT to Do

* ❌ `addSection()` → **Not supported in TemplateProcessor**
* ❌ Trying to insert raw text page breaks (`\n\n`) → Won’t work
* ❌ Cloning sections → Not supported

---

## ✅ Final Result

✔ Page 1 → Quotation
✔ Page 2 → Terms & Conditions
✔ Works perfectly with `cloneRow()`
✔ Word-compatible & safe

---

If you want:

* **Bold headings**
* **Bullet list formatting**
* **Terms table**
* **Company seal/signature page**

Just tell me 👍

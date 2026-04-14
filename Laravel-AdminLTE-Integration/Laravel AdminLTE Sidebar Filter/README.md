You want to **filter students by selected academic year in Laravel AdminLTE sidebar**, using a **global scope / dynamic filter**. Let’s design this cleanly and scalable.

---

## ✅ Goal

* Select **Academic Year** from sidebar (dropdown)
* Store selection (session)
* Automatically filter **Student records** based on selected year
* Apply globally using **Eloquent Scope**

---

## 🧱 Step 1: Add Academic Year Column

Make sure your `students` table has:

```php
$table->unsignedBigInteger('academic_year_id');
```

---

## 🧠 Step 2: Create Global Scope

### Create Scope

```bash
php artisan make:scope AcademicYearScope
```

### `app/Scopes/AcademicYearScope.php`

```php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AcademicYearScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (session()->has('academic_year_id')) {
            $builder->where('academic_year_id', session('academic_year_id'));
        }
    }
}
```

---

## 🔗 Step 3: Apply Scope in Student Model

```php
use App\Scopes\AcademicYearScope;

class Student extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
```

---

## 🎯 Step 4: Sidebar Dropdown (AdminLTE)

Inside sidebar blade:

```blade
<form action="{{ route('set.academic.year') }}" method="POST">
    @csrf
    <select name="academic_year_id" onchange="this.form.submit()" class="form-control">
        @foreach($academicYears as $year)
            <option value="{{ $year->id }}" 
                {{ session('academic_year_id') == $year->id ? 'selected' : '' }}>
                {{ $year->name }}
            </option>
        @endforeach
    </select>
</form>
```

---

## 🚀 Step 5: Route + Controller

### Route

```php
Route::post('/set-academic-year', [AcademicYearController::class, 'set'])
    ->name('set.academic.year');
```

### Controller

```php
public function set(Request $request)
{
    session(['academic_year_id' => $request->academic_year_id]);

    return back();
}
```

---

## 🔄 Step 6: Share Academic Years Globally (Optional but Recommended)

In `AppServiceProvider`:

```php
use App\Models\AcademicYear;

public function boot()
{
    view()->share('academicYears', AcademicYear::all());
}
```

---

## 🧪 Result

Now:

* User selects year → stored in session
* All `Student::query()` automatically filtered
* Works in:

  * Controllers
  * Relationships
  * DataTables
  * APIs

---

## ⚠️ Important Tips

### 1. Bypass Scope When Needed

```php
Student::withoutGlobalScope(AcademicYearScope::class)->get();
```

---

### 2. Add Default Academic Year

```php
if (!session()->has('academic_year_id')) {
    session(['academic_year_id' => AcademicYear::latest()->first()->id]);
}
```

---

### 3. Use Middleware (Cleaner Alternative)

Instead of putting logic in many places:

```bash
php artisan make:middleware SetAcademicYear
```

---

## 💡 Pro Tip (Best Practice)

If your system grows (ERP like yours 👇):

* Enquiry
* Admission
* Fees
* Promotion

👉 Apply this same scope to:

* `Student`
* `Admission`
* `Fee`
* `Promotion`

---

## 🎯 Final Architecture

```
Sidebar → Select Academic Year
        ↓
Session Stored
        ↓
Global Scope Applied
        ↓
All Queries Auto Filtered
```

---

If you want, I can next:
✅ Add **multi-school + academic year filtering**
✅ Add **role-based academic year restriction**
✅ Or integrate into your existing ERP modules (Enquiry → Admission → Student flow)

Just tell 👍

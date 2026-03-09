To pass `$menus = Menu::all()` to all the views in your `HomeController` (`index`, `about_us`, and `contact_us`), follow these steps:

---

### ✅ Step 1: Import the `Menu` model

Make sure to import the `Menu` model at the top of your controller:

```php
use App\Models\Menu;
```

---

### ✅ Step 2: Pass `$menus` to each view using `compact()` or `with()`

Update your controller like this:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::all();
        return view('frontend.home', compact('menus'));
    }

    public function about_us(Request $request)
    {
        $menus = Menu::all();
        return view('frontend.about_us', compact('menus'));
    }

    public function contact_us(Request $request)
    {
        $menus = Menu::all();
        return view('frontend.contact_us', compact('menus'));
    }
}
```

---

### ✅ Optional: Use a constructor if you want `$menus` available in all methods

You can also use the controller constructor to share `$menus` with all methods:

```php
class HomeController extends Controller
{
    protected $menus;

    public function __construct()
    {
        $this->menus = Menu::all();
    }

    public function index(Request $request)
    {
        return view('frontend.home', ['menus' => $this->menus]);
    }

    public function about_us(Request $request)
    {
        return view('frontend.about_us', ['menus' => $this->menus]);
    }

    public function contact_us(Request $request)
    {
        return view('frontend.contact_us', ['menus' => $this->menus]);
    }
}
```

---

### ✅ Blade Usage

In your Blade files (`frontend/home.blade.php`, etc.), you can now use:

```blade
@foreach($menus as $menu)
    <li>{{ $menu->name }}</li>
@endforeach
```

Let me know if you want to load menus globally using a View Composer instead.

Yes! There are cleaner and more reusable ways to pass `$menus = Menu::all()` to all views or controllers using **View Composers**, **Service Providers**, **Traits**, or **Scopes** in Laravel. Here's a breakdown of each method:

---

## ✅ **1. Using a View Composer (Best for Views)**

This is the **recommended Laravel way** to bind data like `$menus` to views.

### Step 1: Create a View Composer class

```bash
php artisan make:provider ViewServiceProvider
```

### Step 2: Register the composer in the provider

In `App\Providers\ViewServiceProvider.php`:

```php
use Illuminate\Support\Facades\View;
use App\Models\Menu;

public function boot()
{
    // Share menus to all views
    View::composer('*', function ($view) {
        $view->with('menus', Menu::all());
    });
}
```

### Step 3: Register the provider in `config/app.php` if not auto-discovered

```php
App\Providers\ViewServiceProvider::class,
```

✅ Now `$menus` is available in **all Blade views** automatically.

---

## ✅ **2. Using a Service Provider to Share Global Data (Works for all views)**

If you want to share it globally (once loaded), update `AppServiceProvider.php`:

```php
use Illuminate\Support\Facades\View;
use App\Models\Menu;

public function boot()
{
    View::share('menus', Menu::all());
}
```

# OR

```php
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share menus (split into chunks of 6) to all views
        View::composer('*', function ($view) {
            $menus = Menu::all()->chunk(6); // chunk into groups of 6
            $view->with('menus', $menus);
        });
    }
}
```


This also makes `$menus` available in **every view**, but it runs only once during application boot.

---

## ✅ **3. Using a Trait (For Reusing in Controllers)**

If you need to load menus in multiple controllers:

### Step 1: Create a Trait

```php
namespace App\Traits;

use App\Models\Menu;

trait HasMenus
{
    public function getMenus()
    {
        return Menu::all();
    }
}
```

### Step 2: Use Trait in Controller

```php
use App\Traits\HasMenus;

class HomeController extends Controller
{
    use HasMenus;

    public function index()
    {
        $menus = $this->getMenus();
        return view('frontend.home', compact('menus'));
    }
}
```

---

## ✅ **4. Using Scope (Not for this case)**

**Eloquent scopes** are for modifying model queries like:

```php
Menu::active()->ordered()->get();
```

If you want to create a reusable query like only active menus:

```php
// In Menu.php
public function scopeActive($query)
{
    return $query->where('status', 1);
}
```

Then use it as:

```php
Menu::active()->get();
```

This is **not for sharing data across views**, but great for filtering.

---

## ✅ Summary: Best Choices

| Goal                                         | Recommended                                            |
| -------------------------------------------- | ------------------------------------------------------ |
| Pass `$menus` to all views                   | ✅ View Composer or `View::share()` in Service Provider |
| Reuse `$menus` logic in multiple controllers | ✅ Trait                                                |
| Filter or modify Menu query                  | ✅ Scope                                                |

Let me know which method you'd prefer based on your use case, and I’ll help you implement it.

#  Laravel 12 React Starter Kit + ShadCN/UI Dashboard 🔥
```
https://www.youtube.com/watch?v=NEOufwo4bQQ
```

```
https://ui.shadcn.com/blocks
```


To **pass the User count from Laravel to your Inertia React dashboard**, you need 3 small changes:

1. **Get the count in Controller**
2. **Pass it to Inertia**
3. **Receive it in React component and show it in the Card**

---

# 1️⃣ Update Laravel Controller

Count users and send to Inertia.

```php
<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userCount = User::count();

        return Inertia::render('Dashboard', [
            'userCount' => $userCount
        ]);
    }
}
```

---

# 2️⃣ Receive Prop in Dashboard Page

Update **Dashboard.tsx**

```tsx
export default function Dashboard({ userCount }: { userCount: number }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <div className="flex flex-1 flex-col">
                <div className="@container/main flex flex-1 flex-col gap-2">
                    <div className="flex flex-col gap-4 py-4 md:gap-6 md:py-6">

                        <SectionCards userCount={userCount} />

                    </div>
                </div>
            </div>

        </AppLayout>
    );
}
```

---

# 3️⃣ Update SectionCards Component

Pass the prop and display it.

```tsx
import { IconTrendingUp } from "@tabler/icons-react"
import { Badge } from "@/components/ui/badge"
import {
  Card,
  CardAction,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"

export function SectionCards({ userCount }: { userCount: number }) {
  return (
    <div className="grid grid-cols-1 gap-4 px-4 lg:px-6 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">

      <Card>
        <CardHeader>
          <CardDescription>Total Users</CardDescription>

          <CardTitle className="text-2xl font-semibold tabular-nums">
            {userCount}
          </CardTitle>

          <CardAction>
            <Badge variant="outline">
              <IconTrendingUp className="mr-1 h-4 w-4"/>
              Active
            </Badge>
          </CardAction>

        </CardHeader>

        <CardFooter className="flex-col items-start gap-1.5 text-sm">
          <div className="flex gap-2 font-medium">
            Registered users in system
          </div>

          <div className="text-muted-foreground">
            Live database count
          </div>
        </CardFooter>

      </Card>

    </div>
  )
}
```

---

# 4️⃣ Result

Your dashboard card will now show:

```
Total Users
25
```

(dynamic from database)

---

✅ **Next Level (Recommended for Production Dashboard)**
You can also add:

* Total Orders
* Total Products
* Today's Sales
* Monthly Revenue

Example:

```php
return Inertia::render('Dashboard', [
    'stats' => [
        'users' => User::count(),
        'orders' => Order::count(),
        'products' => Product::count(),
    ]
]);
```

---

If you want, I can also show a **🔥 Professional SaaS Dashboard Layout (4 cards + charts + recent activity)** for your **Laravel + React + ShadCN + Inertia project**.


Your issue is that you are using **`Route::inertia()`** but you want to use a **Controller (`DashboardController`)** to pass the user count.
So you must **replace the inertia route with the controller route**.

---

# ✅ Fixed Route (Correct Way)

```php
<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\Backend\DashboardController;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});

require __DIR__.'/settings.php';
```

---

# ❌ Remove This

Remove this line because it bypasses the controller.

```php
Route::inertia('dashboard', 'dashboard')->name('dashboard');
```

---

# ✅ Final Flow

```
Route
   ↓
DashboardController
   ↓
return Inertia::render('Dashboard', [
    'userCount' => User::count()
]);
   ↓
Dashboard.tsx
   ↓
SectionCards
   ↓
Display Count
```

---

# ⚠️ Small Important Fix

Make sure your **Inertia page name matches**:

Controller:

```php
return Inertia::render('Dashboard', [
    'userCount' => $userCount
]);
```

File:

```
resources/js/Pages/Dashboard.tsx
```

NOT:

```
category.tsx
dashboard.tsx (case sensitive in production)
```

---

# ⭐ Best Practice (Recommended)

Later you can create **Dashboard Stats API style**:

```php
return Inertia::render('Dashboard', [
    'stats' => [
        'users' => User::count(),
        'orders' => Order::count(),
        'categories' => Category::count(),
        'products' => Product::count(),
    ]
]);
```

Then your dashboard cards become **fully dynamic**.

---

✅ If you want, I can also show a **🔥 production-ready Laravel + Inertia + ShadCN Dashboard** with:

* Animated stats cards
* Charts (Sales / Orders)
* Latest users table
* Activity timeline
* Fully responsive layout.

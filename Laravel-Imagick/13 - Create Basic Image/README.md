# 1 - Generate HomeController

```
php artisan make:controller HomeController
```
# 2 - HomeController.php

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Imagick;
use ImagickDraw;
use ImagickPixel;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{    

    public function index()
    {

        // Load the Imagick library
        $imagick = new Imagick();

        // Create a new image with a white background
        $imagick->newImage(800, 200, new ImagickPixel('white'));

        // Set the image format to png
        $imagick->setImageFormat('png');

        // Get the image blob
        $imageBlob = $imagick->getImageBlob();        

        // Create a response with the image blob
        return response($imageBlob, 200)->header('Content-Type', 'image/png');

    }
}
```

# 3 - web.php

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class,'index']);
```
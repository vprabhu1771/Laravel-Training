`HomeController.php`

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

    public function index2()
    {
        $imagePath = public_path('dog.jpg');
        
        // Create an Imagick object
        $imagick = new Imagick($imagePath);

        // Get the Image Size 
        $size = $imagick->getImageSize(); 
        echo 'Image size is '. $size . ' bytes.'; 
    }
    
}
```

![Image](1.PNG)
Guide
1. Install the Package
First, install the simplesoftwareio/simple-qrcode package via Composer in your Laravel project: 

```bash
composer require simplesoftwareio/simple-qrcode
```
Laravel's auto-discovery feature will typically handle the service provider and facade registration automatically. 

2. Place Your Logo
Place your logo image (e.g., logo.png) in your public directory. A common path would be public/images/logo.png. 

3. Generate the QR Code in a Controller 
You can generate the QR code within a controller method and return it as a response, or pass it to a Blade view. 
Here is an example of a controller method that generates a QR code with a merged logo:


```php
<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function generateWithLogo()
    {
        // Define the path to your logo
        $logoPath = public_path('images/logo.png');
        
        // Generate the QR code with the logo merged in the center
        $image = QrCode::format('png')
            ->merge($logoPath, 0.3, true) // Merge the image (logoPath), at 30% size (0.3), and enable automatic error correction (true)
            ->size(500) // Set the overall size of the QR code
            ->errorCorrection('H') // Use 'H' (high) error correction to ensure the QR code remains scannable with the logo
            ->generate('https://www.example.com/your-content'); // The content of the QR code

        // Return the image as a response
        return response($image)->header('Content-type', 'image/png');
    }
}
```
 

    ->format('png'): Specifies the output format as PNG. This is necessary for image merging.
    ->merge($logoPath, 0.3, true): This is the key method. The second parameter (0.3 or 30%) controls the logo's size relative to the QR code, and the third parameter automatically adjusts error correction.
    ->errorCorrection('H'): Setting the error correction level to 'H' (High) is important when adding a logo, as it adds redundancy to the QR code data, making it more resilient to the obstruction caused by the logo. 

4. Define the Route
Add a route in your routes/web.php file to access the controller method: 

```php
use App\Http\Controllers\QRCodeController;

Route::get('/qr-code-with-logo', [QRCodeController::class, 'generateWithLogo']);
```

5. View the Result
Run your Laravel application using php artisan serve and visit the route in your browser (e.g., http://localhost:8000/qr-code-with-logo). You should see the generated QR code with your logo in the middle. 
Displaying in a Blade Template
If you prefer to generate the QR code and display it within a Blade view, you can use base64 encoding to embed the image data directly: 

```php
// In your controller:
public function showInView()
{
    $logoPath = public_path('images/logo.png');
    $image = QrCode::format('png')
            ->merge($logoPath, 0.3, true)
            ->size(300)
            ->errorCorrection('H')
            ->generate('https://www.example.com/your-content');
    
    // Convert to base64 for embedding in HTML
    $imageData = base64_encode($image);

    return view('qrcode', compact('imageData'));
}
```

```blade
{{-- resources/views/qrcode.blade.php --}}
<!DOCTYPE html>
<html>
<body>
    <h1>QR Code with Logo</h1>
    {{-- Embed the base64 image data --}}
    <img src="data:image/png;base64,{{ $imageData }}" alt="QR Code">
</body>
</html>
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{    

    public function index()
    {
        $imagePath = public_path('dog.jpg');
        
        // Create an image resource from the given image path
        $image = imagecreatefromjpeg($imagePath);
        
        // Set the content type header
        header("Content-Type: image/jpeg");
        
        // Output the image
        imagejpeg($image);
        
        // Free up memory
        imagedestroy($image);
    }
}

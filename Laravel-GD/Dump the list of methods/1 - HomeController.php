<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{    
    public function index2()
    {
        $imagePath = public_path('dog.jpg');

        if (!file_exists($imagePath)) {
            throw new \Exception("Image file not found at: " . $imagePath);
        }
        
        // Create an image resource from the given image path
        $image = imagecreatefromjpeg($imagePath);
        
        // Get the image size in bytes
        $size = filesize($imagePath);
        
        echo 'Image size is ' . $size . ' bytes.';

        // Get the list of functions available for GD images
        $functions = get_extension_funcs('gd');
        
        // Dump the list of functions
        dd($functions);
        
        // Free up memory
        imagedestroy($image);
    }
}

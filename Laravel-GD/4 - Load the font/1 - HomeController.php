<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{    
    public function index()
    {
        // Create a blank image with a white background
        $image = imagecreatetruecolor(800, 200);

        // Allocate a color for the background (white)
        $white = imagecolorallocate($image, 255, 255, 255);

        // Fill the image with white color
        imagefilledrectangle($image, 0, 0, 800, 200, $white);

        // Allocate a color for the text (black)
        $black = imagecolorallocate($image, 0, 0, 0);

        // Load the Tamil font
        $fontPath = public_path('Bamini.ttf');

        if (!file_exists($fontPath)) {
            throw new \Exception("Font file not found at: " . $fontPath);
        }

        // Set the font size (GD uses point sizes)
        $fontSize = 50;

        // The Tamil text to write
        $text = 'Mk;kh';

        // Calculate the bounding box for the text
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);

        // Calculate the position to center the text
        $x = (800 - ($bbox[2] - $bbox[0])) / 2;
        $y = (200 - ($bbox[7] - $bbox[1])) / 2 + $fontSize;

        // Add the text to the image
        imagettftext($image, $fontSize, 0, $x, $y, $black, $fontPath, $text);

        // Start output buffering to capture the image data
        ob_start();

        // Output the image as PNG
        imagepng($image);

        // Get the image data from the buffer
        $imageBlob = ob_get_clean();

        // Free up memory
        imagedestroy($image);

        // Create a response with the image blob
        return response($imageBlob, 200)->header('Content-Type', 'image/png');
    }
}

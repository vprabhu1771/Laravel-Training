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


        // Create a new ImagickDraw object
        $draw = new ImagickDraw();

        // Set the font size
        $draw->setFontSize(50);

        // Set the fill color to black
        $draw->setFillColor('black');

        // Set the text encoding to UTF-8
        $draw->setTextEncoding('UTF-8');

        // The text to write        
        $text = 'abcd';        

        // Calculate the position to center the text
        $metrics = $imagick->queryFontMetrics($draw, $text);
        $x = (800 - $metrics['textWidth']) / 2;
        $y = (200 - $metrics['textHeight']) / 2 + $metrics['ascender'];

        // Add the text to the image
        $imagick->annotateImage($draw, $x, $y, 0, $text);



        // Get the image blob
        $imageBlob = $imagick->getImageBlob();        

        // Create a response with the image blob
        return response($imageBlob, 200)->header('Content-Type', 'image/png');

    }
}

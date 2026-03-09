`WordController.php`

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

// Import Model
use App\Models\Student;

class WordController extends Controller
{
    public function processWordTemplate($studentId)
    {
        // Load the Word template
        $templateProcessor = new TemplateProcessor(public_path('template.docx'));

        // Fetch student information from the database
        $student = Student::find($studentId);

        // If the student is not found, return a not found response
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        // Replace placeholders with actual data
        $templateProcessor->setValue('name', $student->name);
        $templateProcessor->setValue('email', $student->email);

        // Save the processed Word document
        $outputFilePath = public_path('output.docx');
        $templateProcessor->saveAs($outputFilePath);

         // Create a JSON response
         $response = ['message' => 'Word document processed and sent successfully'];

        
        // Download the processed Word document and delete the file after sending
        return response()               
            ->download($outputFilePath)
            ->deleteFileAfterSend(true)
            ->json($response);    
    }
}
```

Create Word docx `template.docx`

```
Date: 2024-01-16
 
Dear ${name},
 
This is to inform you that you have successfully completed your studies.
 
Sincerely,
Your School Name

Note: Certificate Copy Sent to Email to ${email}

```

`LetterController.php`

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

use App\Models\Student;

class LetterController extends Controller
{
    public function generateLetter($studentId)
    {
        // Fetch student information from the database
        $student = Student::find($studentId);

        // Create a new PHPWord instance
        $phpWord = new PhpWord();

        // Create a new section
        $section = $phpWord->addSection();

        // Add content to the section (customize this based on your needs)
        $section->addText('Date: ' . date('Y-m-d'));
        $section->addText(' ');
        $section->addText('Dear ' . $student->name . ',');
        $section->addText(' ');
        $section->addText('This is to inform you that you have successfully completed your studies.');
        $section->addText(' ');
        $section->addText('Sincerely,');
        $section->addText('Your School Name');

        // Save the document
        $filename = 'letter_' . $student->id . '.docx';
        $path = storage_path('app/public/letters/' . $filename);
        $phpWord->save($path);

        // Return the path to the generated letter

        // Initiate the download without deleting the file after sending the response
        return response()->download($path)->deleteFileAfterSend(false);

        // Initiate the download and delete the file after sending the response
        return response()->download($path)->deleteFileAfterSend(true);
    }
}
```

`web.php`

```
use App\Http\Controllers\LetterController;

Route::get('/generate-letter/{studentId}', [LetterController::class, 'generateLetter']);

use App\Http\Controllers\WordController;

Route::get('/process-word-template/{studentId}', [WordController::class, 'processWordTemplate']);
```
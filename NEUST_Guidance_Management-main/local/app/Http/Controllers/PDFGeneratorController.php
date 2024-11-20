<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFGeneratorController extends Controller
{
    public function generatePdf($data, $layout, $filename = 'generated.pdf')
    {
        try {
            $pdf = PDF::loadView($layout, $data);
            return $pdf->download($filename);
        } catch (\Exception $e) {
            throw new \Exception('Failed to generate PDF: ' . $e->getMessage());
        }
    }

    public function makePDF($data, $layout, $filename = 'generated.pdf')
    {
        try {
            $pdf = PDF::loadView($layout, $data);
            // Save the PDF to the public folder
            $pdf->save(public_path('uploads/'.$filename));

            return response()->json(['message' => 'PDF generated and saved successfully', 'file' => $filename], 200);
        } catch (\Exception $e) {
            throw new \Exception('Failed to generate PDF: ' . $e->getMessage());
        }
    }
}

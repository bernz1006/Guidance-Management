<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Smalot\PdfParser\Parser;

class ModuleController extends Controller
{
    public function uploadModule(Request $request)
    {
        // Check if a file is present in the request
        if ($request->hasFile('module_pdf')) {
            // Retrieve the file from the request
            $file = $request->file('module_pdf');
            $filename = $file->getClientOriginalName();
            $filePath = 'modules_pdf/' . $filename;

            // Move the file to the public/modules_pdf directory
            $file->move(public_path('modules_pdf'), $filename);

            // Parse the PDF to get the number of pages and metadata
            $parser = new Parser();
            $pdf = $parser->parseFile(public_path($filePath));
            $pages = count($pdf->getPages());


            // Save the information in the database
            DB::table('career_guidance_module')->insert([
                'title' => pathinfo($filename, PATHINFO_FILENAME),
                'pages' => $pages,
                'file' => $filename,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'File uploaded successfully'], 200);
        } else {
            // Return an error response if no file was uploaded
            return response()->json(['error' => 'No file uploaded'], 400);
        }
    }

    public function deleteModule(Request $request)
    {
        // Retrieve the module information from the database
        $module = DB::table('career_guidance_module')->where('id', $request->input('id'))->first();

        if ($module) {
            // Delete the module record from the database
            $status = DB::table('career_guidance_module')->where('id', $request->input('id'))->delete();

            if ($status) {
                // Unlink (delete) the file from the server
                $filePath = public_path('modules_pdf/' . $module->file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                return response()->json('Module has been deleted.');
            } else {
                return response()->json('Error deleting module from the database.');
            }
        } else {
            return response()->json('Module not found.', 404);
        }
    }
}

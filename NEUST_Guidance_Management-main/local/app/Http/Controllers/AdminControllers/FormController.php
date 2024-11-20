<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Exception;
use App\Http\Controllers\PDFGeneratorController;
use Carbon\Carbon;
use App\Models\Drops;

class FormController extends Controller
{
    public function downloadForm(Request $request){
        $cert = $request->input('id');

        $currentDate = Carbon::now();

        $info = [
            'school_year' => ($currentDate->year - 1) . '-' . $currentDate->year,
            'date_day' => $currentDate->format('j'), // Example: '6th'
            'date_day_superscript' => $currentDate->format('S'),
            'date_month' => $currentDate->format('F'), // Example: 'July'
            'date_year' => $currentDate->format('Y'), // Example: '2024'
            'current_date' => $currentDate->format('F j, Y'),
        ];

        if($cert == 2){
            $filename = 'good_moral_certificate.pdf';
            $layout = 'form_layout.form_good_moral';

            try {
                $pdfGenerator = new PDFGeneratorController();
                return $pdfGenerator->generatePdf($info, $layout, $filename);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

        }elseif($cert == 3){
            $filename = 'home_visitation.pdf';
            $layout = 'form_layout.form_home_visitation';

            try {
                $pdfGenerator = new PDFGeneratorController();
                return $pdfGenerator->generatePdf($info, $layout, $filename);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

        }elseif($cert == 4){
            $filename = 'travel_form.pdf';
            $layout = 'form_layout.form_travel_form';

            try {
                $pdfGenerator = new PDFGeneratorController();
                return $pdfGenerator->generatePdf($info, $layout, $filename);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

        }
    }

    public function customizeGMCert(Request $request){

        $student = DB::table('students')->where('id', $request->input('student'))->first();
        $name = $name = ucwords($student->firstname . ' ' . $student->middlename . ' ' . $student->lastname . ' ' . $student->suffix);
        $currentDate = Carbon::now();

        $info = [
            'name' => $name,
            'school_year' => ($currentDate->year - 1) . '-' . $currentDate->year,
            'date_day' => $currentDate->format('j'), // Example: '6th'
            'date_day_superscript' => $currentDate->format('S'),
            'date_month' => $currentDate->format('F'), // Example: 'July'
            'date_year' => $currentDate->format('Y'), // Example: '2024'
            'current_date' => $currentDate->format('F j, Y'),
        ];

        $filename = $student->lastname . '_good_moral_certificate.pdf';
        $layout = 'form_layout.form_customize_good_moral';

        try {
            $pdfGenerator = new PDFGeneratorController();
            return $pdfGenerator->generatePdf($info, $layout, $filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function customizeHomeVisitation(Request $request){

        $student = DB::table('students')->where('id', $request->input('student'))->first();
        $name = $name = ucwords($student->firstname . ' ' . $student->middlename . ' ' . $student->lastname . ' ' . $student->suffix);
        $currentDate = Carbon::now();

        $absence = Carbon::parse($request->input('absence'))->format('F j, Y');

        $info = [
            'name' => $name,
            'current_date' => $currentDate->format('F j, Y'),
            'gradeSec' => $request->input('gradeSec'),
            'address' => $request->input('address'),
            'parGuar' => $request->input('parGuar'),
            'number' => $request->input('number'),
            'absence' => $absence,
            'problem' => $request->input('problem'),
            'actionTaken' => $request->input('actionTaken'),
            'recommendation' => $request->input('recommendation'),
            'adviser' => $request->input('adviser'),
            'parent' => $request->input('parent'),
            'learner' => $name,
            'ht' => $request->input('ht'),
            'coordinator' => $request->input('coordinator'),
        ];

        $filename = $student->lastname . '_home_visitation_form.pdf';
        $layout = 'form_layout.form_customize_home_visitation';

        try {
            $pdfGenerator = new PDFGeneratorController();
            return $pdfGenerator->generatePdf($info, $layout, $filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function customizeTravelForm(Request $request){

        $when = Carbon::parse($request->input('when'))->format('F j, Y');
        $hours = Carbon::parse($request->input('hours'))->format('H:i a');


        $info = [
            'where' => $request->input('where'),
            'when' => $when,
            'hours' => $hours,
            'adviser' => $request->input('adviser'),
            'headT' => $request->input('headT'),
        ];

        $filename = 'travel_form.pdf';
        $layout = 'form_layout.form_customize_travel_form';

        try {
            $pdfGenerator = new PDFGeneratorController();
            return $pdfGenerator->generatePdf($info, $layout, $filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function downloadSardo(){
        $filename = 'sardo_list.pdf';
        $layout = 'form_layout.form_sardo';

        $grades = DB::table('grade_level')->get();

        $info = [];

        foreach($grades as $grade){
            $count = Drops::leftJoin('students', 'drop_request.student_id', '=', 'students.id')
                                        ->leftJoin('grade_level', 'students.current_grade', '=', 'grade_level.id')
                                        ->where('grade_level.id', $grade->id)
                                        ->where('drop_request.status', '=', '1')
                                        ->count();

            $info['grade_id_'. $grade->id] = $count;
        }

        try {
            $pdfGenerator = new PDFGeneratorController();
            return $pdfGenerator->generatePdf($info, $layout, $filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

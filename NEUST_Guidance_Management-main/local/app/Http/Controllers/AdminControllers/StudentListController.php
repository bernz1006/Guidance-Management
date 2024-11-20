<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use Exception;
use App\Http\Controllers\PDFGeneratorController;
use Carbon\Carbon;

class StudentListController extends Controller
{
    public function UpdateStudentInfo(Request $request){

        $studentData = [
            'lrn' => $request->input('lrn'),
            'elem_school' => $request->input('elem_school'),
            'current_grade' => $request->input('current_grade_options'),
            'current_section' => $request->input('current_section_options'),
            'gen_average' => $request->input('gen_average'),
            'adviser' => $request->input('adviser'),
            'updated_at' => now()
        ];

        // dd($studentData);

        try{
            $status = DB::table('students')->where('id', $request->input('student_id'))->update($studentData);
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with('error_update', 'Profile updated failed!');
        }

        if($status){
            // if($check_email != $request->input('profile_email')){
            //     $update_user_email = DB::table('users')->where('id', Auth::user()->id)->update(['email' => $request->input('profile_email')]);

            //     if(!$update_user_email){
            //         return redirect()->back()->with('error_update', 'Profile updated failed!');
            //     }
            // }

            // $update_time = DB::table('students')->where('id', $student_id)->update([]);
            return redirect()->back()->with('status_update', 'Profile updated successfully!');
        }else{
            return redirect()->back()->with('status_no_update', 'No changes made.');
        }
    }

    public function sendEmail(Request $request)
    {
        $student = DB::table('students')->where('id', $request->input('id'))->first();
        $layout = 'mail_layout.student_email';
        $subject = 'Student Profile Completion for Bongabon Guidance Management System';

        try {
            $data = [
                'name' => $student->firstname,
            ];

            Mail::to($student->email)->send(new Mailer($data, $layout, $subject));

            return response()->json(['message' => 'Email sent successfully!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function downloadStudentInfo(Request $request)
    {
        $studentId = $request->input('id');

        $student = DB::table('students')->where('id', $studentId)->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        $profile_img = $student->student_img == null ? asset('img/default.jpg') : route('student.image', ['id' => $student->id]);
        $current_grade = DB::table('grade_level')->where('id', $student->current_grade)->value('grade_level');
        $current_section = DB::table('sections')->where('id', $student->current_section)->value('section_name');
        $adviser = DB::table('advisers')->where('id', $student->adviser)->value('adviser_name');
        $birthday = Carbon::createFromFormat('Y-m-d', $student->birthday)->format('F j, Y');
        $last_update =  Carbon::parse($student->updated_at)->format('F j, Y'). ' at ' .Carbon::parse($student->updated_at)->format('g:i a');
        $birthDateCarbon = Carbon::createFromFormat('Y-m-d', $student->birthday);

        $currentDate = Carbon::now();
        $currentYear = $currentDate->format('y');
        $student_age = $birthDateCarbon->diffInYears($currentDate);

        $student_province = DB::table('philippine_provinces')->where('province_code', $student->province)->value('province_description') ?? 'N/A';
        $student_municipality = DB::table('philippine_cities')->where('city_municipality_code', $student->municipality)->value('city_municipality_description') ?? 'N/A';
        $student_baranggay = DB::table('philippine_barangays')->where('barangay_code', $student->baranggay)->value('barangay_description') ?? 'N/A';

        if($current_grade == 'Grade 7'){
            $last_grade = 'Grade 6';
        }else if($current_grade == 'Grade 8'){
            $last_grade = 'Grade 7';
        }else if($current_grade == 'Grade 9'){
            $last_grade = 'Grade 8';
        }if($current_grade == 'Grade 10'){
            $last_grade = 'Grade 9';
        }

        $student_info = [
            'student_img' => $profile_img,
            'email' => $student->email,
            'name' => $student->firstname.' '.$student->middlename.' '.$student->lastname.' '.$student->suffix,
            'lrn' => $student->lrn,
            'house_no_street' => $student->house_no_street,
            'baranggay' => $student_baranggay,
            'municipality' => $student_municipality,
            'province' => $student_province,
            'contact_no' => $student->contact_no,
            'birthday' => $birthday,
            'age' => $student_age,
            'sex' => $student->sex,
            'nationality' => $student->nationality,
            'religion' => $student->religion,
            'father' => $student->father,
            'father_occupation' => $student->father_occupation,
            'mother' => $student->mother,
            'mother_occupation' => $student->mother_occupation,
            'living_with' => $student->living_with,
            'no_of_siblings' => $student->no_of_siblings,
            'position' => $student->position,
            'elem_school' => $student->elem_school,
            'school_id' => $student->school_id,
            'gen_average' => $student->gen_average,
            'last_grade' => $last_grade,
            'current_grade' => $current_grade,
            'current_section' => $current_section,
            'adviser' => $adviser,
        ];

        $filename = $student->firstname . '_' . $student->lastname .'.pdf';
        $layout = 'pdf_layout.pdf_student_info';

        try {
            $pdfGenerator = new PDFGeneratorController();
            return $pdfGenerator->generatePdf($student_info, $layout, $filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

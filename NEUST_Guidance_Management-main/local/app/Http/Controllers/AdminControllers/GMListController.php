<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use Exception;
use App\Http\Controllers\PDFGeneratorController;
use Carbon\Carbon;

class GMListController extends Controller
{
    public function approveGoodMoralItem(Request $request){

        $gm = DB::table('goodmoral_request')->where('request_id', $request->input('gm_id'))->first();
        $student = DB::table('students')->where('id', $gm->student_id)->first();

        $data = [
            'notes' => $request->input('notes'),
            'status' => 3,
        ];

        $email_data = [
            'subject' => 'Your good moral request has been approved by the counselor - Request Number (#'.$gm->request_id.')',
            'email_header' => 'Student good moral request approved',
            'email_description' => 'Good day '. ucwords($student->firstname) .'! Your good moral request about "'.$gm->reason.'" requested on '.$gm->request_date.' has been approved by the guidance counselor. Please see the attached file. Thank you!',
            'email_notes' => 'Notes: '.$request->input('notes'),
        ];

        $pdfName = $student->lastname.'_gmcert.pdf';

        $this->makeGMCert($student, $pdfName);

        $pdfPath = public_path('uploads/'.$pdfName);

        try{
            $status = DB::table('goodmoral_request')->where('request_id', $request->input('gm_id'))->update($data);
            $this->mailGoodMoralApproved($email_data, $student->email, $pdfPath, $pdfName);

            // Remove the file after sending the email
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }

        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with('error_update', 'Processing of request failed! Please try again.');
        }

        if($status){
            $update_time = DB::table('goodmoral_request')->where('request_id', $request->input('gm_id'))->update(['updated_at' => now()]);
            return response()->json('Request approved successfully!');
        }else{
            return response()->json('No changes made.');
        }
    }

    public function updateGoodMoralStatus(Request $request){
        $gm = DB::table('goodmoral_request')->where('request_id', $request->input('gm_id'))->first();
        $student = DB::table('students')->where('id', $gm->student_id)->first();

        $status = DB::table('goodmoral_request')->where('request_id', $request->input('gm_id'))->update(['status' => $request->input('id')]);


        if($request->input('id') == 1){
            $response = 'Good moral request of student has been updated into pending.';
        }else if($request->input('id') == 2){
            $response = 'Good moral request of student has been cancelled.';

            $email_data = [
                'subject' => 'Your good moral request has been cancelled by the counselor - Request Number (#'.$gm->request_id.')',
                'email_header' => 'Student good moral request cancelled',
                'email_description' => 'Good day '. ucwords($student->firstname) .'! Your good moral request about "'.$gm->reason.'" requested on '.$gm->request_date.' has been cancelled by the guidance counselor. Please contact the guidance counselor if this is a mistake. Thank you!',
                'email_notes' => '',
            ];
            $this->mailGoodMoralUpdate($email_data, $student->email);
        }else if($request->input('id') == 4){
            $response = 'Good moral request marked as completed.';

            $email_data = [
                'subject' => 'Your good moral request has been completed by the counselor - Request Number (#'.$gm->request_id.')',
                'email_header' => 'Student good moral request completed',
                'email_description' => 'Good day '. ucwords($student->firstname) .'! Your good moral request about "'.$gm->reason.'" requested on '.$gm->request_date.' has been completed by the guidance counselor. Please contact the guidance counselor if this is a mistake. Thank you!',
                'email_notes' => '',
            ];
            $this->mailGoodMoralUpdate($email_data, $student->email);
        }

        if($status){
            $update_time = DB::table('goodmoral_request')->where('request_id', $request->input('gm_id'))->update(['updated_at' => now()]);
            return response()->json($response);
        }else{
            return response()->json('Error');
        }
    }

    public function downloadGoodMoralForm(Request $request){
        $data = DB::table('goodmoral_request')->where('request_id', $request->input('id'))->first();
        $student = DB::table('students')->where('id', $data->student_id)->first();

        $filename = 'good_moral_certificate.pdf';
        $layout = 'pdf_layout.pdf_good_moral';

        // Get the current date
        $currentDate = Carbon::now();

        $info = [
            'name' => ucwords($student->firstname.' '.$student->middlename.' '.$student->lastname.' '.$student->suffix),
            'school_year' => ($currentDate->year - 1) . '-' . $currentDate->year,
            'date_day' => $currentDate->format('j'), // Example: '6th'
            'date_day_superscript' => $currentDate->format('S'),
            'date_month' => $currentDate->format('F'), // Example: 'July'
            'date_year' => $currentDate->format('Y'), // Example: '2024'
        ];

        try {
            $pdfGenerator = new PDFGeneratorController();
            return $pdfGenerator->generatePdf($info, $layout, $filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function archiveGoodMoralItem(Request $request){
        $status = DB::table('goodmoral_request')->where('request_id', $request->input('id'))->update(['isActive' => '0']);

        if($status){
            $update_time = DB::table('goodmoral_request')->where('request_id', $request->input('id'))->update(['updated_at' => now()]);
            return response()->json('Drop request has been archived.');
        }else{
            return response()->json('Error.');
        }
    }

    private function mailGoodMoralUpdate($data, $email){
        $layout = 'mail_layout.request_update_email';
        $subject = $data['subject'];


        try {
            Mail::to($email)->send(new Mailer($data, $layout, $subject));

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function mailGoodMoralApproved($data, $email, $pdfPath, $pdfName){
        $layout = 'mail_layout.request_update_email';
        $subject = $data['subject'];

        try {
            Mail::to($email)->send(new Mailer($data, $layout, $subject, $pdfPath, $pdfName));

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function makeGMCert($student, $filename){
        $layout = 'pdf_layout.pdf_good_moral';

        // Get the current date
        $currentDate = Carbon::now();

        $info = [
            'name' => ucwords($student->firstname.' '.$student->middlename.' '.$student->lastname.' '.$student->suffix),
            'school_year' => ($currentDate->year - 1) . '-' . $currentDate->year,
            'date_day' => $currentDate->format('j'), // Example: '6th'
            'date_day_superscript' => $currentDate->format('S'),
            'date_month' => $currentDate->format('F'), // Example: 'July'
            'date_year' => $currentDate->format('Y'), // Example: '2024'
        ];

        try {
            $pdfGenerator = new PDFGeneratorController();
            return $pdfGenerator->makePDF($info, $layout, $filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

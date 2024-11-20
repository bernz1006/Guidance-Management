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

class DropListController extends Controller
{
    public function approveDropItem(Request $request){

        $drop = DB::table('drop_request')->where('drop_request_id', $request->input('drop_id'))->first();
        $student = DB::table('students')->where('id', $drop->student_id)->first();

        $data = [
            // 'drop_request_id' => $request->input('drop_id'),
            'notes' => $request->input('notes'),
            'status' => 3,
        ];

        $email_data = [
            'subject' => 'Your drop request has been approved by the counselor',
            'email_header' => 'Student drop request approved',
            'email_description' => 'Good day '. ucwords($student->firstname) .'! Your drop request about "'.$drop->reason.'" requested on '.$drop->request_date.' has been approved by the guidance counselor. Your account now is prohibited on accessing the system. Please contact the guidance counselor if this is a mistake. Thank you!',
            'email_notes' => 'Notes: '.$request->input('notes'),
        ];

        try{
            $status = DB::table('drop_request')->where('drop_request_id', $request->input('drop_id'))->update($data);
            $update_student = DB::table('students')->where('id', $student->id)->update(['student_status' => '0']);
            $this->mailDropUpdate($email_data, $student->email);

        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with('error_update', 'Processing of request failed! Please try again.');
        }

        if($status){
            $update_time = DB::table('drop_request')->where('drop_request_id', $request->input('drop_id'))->update(['updated_at' => now()]);
            return response()->json('Request approved successfully! Email sent to the student.');
        }else{
            return response()->json('No changes made.');
        }
    }

    public function updateDropStatus(Request $request){

        $drop = DB::table('drop_request')->where('drop_request_id', $request->input('drop_id'))->first();
        $student = DB::table('students')->where('id', $drop->student_id)->first();

        $status = DB::table('drop_request')->where('drop_request_id', $request->input('drop_id'))->update(['status' => $request->input('id')]);

        if($request->input('id') == 1){
            $response = 'Dropping request of student has been updated into pending.';

        }else if($request->input('id') == 2){
            $response = 'Dropping request of student has been cancelled. Email sent to the student!';

            $email_data = [
                'subject' => 'Your drop request has been cancelled by the counselor',
                'email_header' => 'Student drop request cancelled',
                'email_description' => 'Good day '. ucwords($student->firstname) .'! Your drop request about "'.$drop->reason.'" requested on '.$drop->request_date.' has been cancelled by the guidance counselor. Please contact the guidance counselor if this is a mistake. Thank you!',
                'email_notes' => '',
            ];

            $this->mailDropUpdate($email_data, $student->email);

        }else if($request->input('id') == 4){
            $response = 'Dropping request marked as completed. Email sent to the student!';

            $email_data = [
                'subject' => 'Your concern has been completed by the counselor',
                'email_header' => 'Student concern completed',
                'email_description' => 'Good day '. ucwords($student->firstname) .'! Your concern about "'.$drop->reason.'" requested on '.$drop->request_date.' has been completed by the guidance counselor. Please contact the guidance counselor if this is a mistake. Thank you!',
                'email_notes' => '',
            ];

            $this->mailDropUpdate($email_data, $student->email);
        }

        if($status){
            $update_time = DB::table('drop_request')->where('drop_request_id', $request->input('drop_id'))->update(['updated_at' => now()]);
            return response()->json($response);
        }else{
            return response()->json('Error');
        }
    }

    public function downloadDropForm(Request $request){

    }

    public function archiveDropItem(Request $request){
        $status = DB::table('drop_request')->where('drop_request_id', $request->input('id'))->update(['isActive' => '0']);

        if($status){
            $update_time = DB::table('drop_request')->where('drop_request_id', $request->input('id'))->update(['updated_at' => now()]);
            return response()->json('Drop request has been archived.');
        }else{
            return response()->json('Error');
        }
    }

    private function mailDropUpdate($data, $email){
        $layout = 'mail_layout.request_update_email';
        $subject = $data['subject'];

        try {
            Mail::to($email)->send(new Mailer($data, $layout, $subject));

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

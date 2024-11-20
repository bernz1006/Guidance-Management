<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use Carbon\Carbon;
class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $response = $next($request);
        //     $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        //     $response->header('Pragma', 'no-cache');
        //     $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        //     return $response;
        // });
    }

    public function viewDashboard(){

        $no_of_report = DB::table('student_concern')->count();
        $no_of_drop = DB::table('drop_request')->where('isActive', '1')->count();
        $no_of_gm = DB::table('goodmoral_request')->where('isActive', '1')->count();

        $total_request = $no_of_report + $no_of_drop + $no_of_gm;

        $data['no_of_cases'] = DB::table('student_concern')->count();
        $data['no_of_request_forms'] = $total_request;
        $data['completed_appointments'] = DB::table('appointment_request')->where('status', 4)->count();
        $data['no_of_students'] = DB::table('students')->count();

        $events = [];

        $appointments = DB::table('appointment_request')->where('status', '3')->get();

        foreach ($appointments as $appointment) {

            $student = DB::table('students')->where('id', $appointment->student_id)->first();
            $name = $student->firstname . ' ' . $student->lastname;

            $events[] = [
                'title' => 'Subject: ' . $appointment->subject,
                'start' => $appointment->appointment_date . ' ' . $appointment->appointment_time_from,
                'end' => $appointment->appointment_date . ' ' . $appointment->appointment_time_to,
            ];
        }

        // dd($events);

        return view('admin.admin_dashboard', ['data' => $data], compact('events'));
    }

    public function viewStudentList(){
        $grade_levels = DB::table('grade_level')->get();
        $advisers = DB::table('advisers')->get();

        return view('admin.admin_studentList', ['grade_levels' => $grade_levels, 'advisers' => $advisers]);
    }

    public function viewCreateModule(){
        return view('admin.admin_createModule');
    }

    public function viewCOC(){
        return view('admin.admin_coc');
    }

    public function viewDropRequestList(){

        $this->autoUpdateDropRequestStatus();

        return view('admin.admin_dropRequestList');
    }

    private function autoUpdateDropRequestStatus(){
        // Get current date
        $today = Carbon::today();

        // Query all pending drop requests
        $pendingRequests = DB::table('drop_request')->where('status', '1')->get();

        foreach ($pendingRequests as $request) {
            // Parse the request date
            $requestDate = Carbon::parse($request->request_date)->startOfDay();

            // Check if the request date is before the current date
            if ($requestDate->lt($today)) {
                // Update the status to cancelled (2)
                DB::table('drop_request')
                    ->where('drop_request_id', $request->drop_request_id)
                    ->update(['status' => 2]);

                $student = DB::table('students')->where('id', $request->student_id)->first();

                $email_data = [
                    'subject' => 'Your drop request has been automatically canceled by the system',
                    'email_header' => 'Student drop request canceled',
                    'email_description' => 'Good day '. ucwords($student->firstname) .'! Your drop request about "'.$request->reason.'" requested on '.$request->request_date.' has been automatically cancelled by the system. Please contact the guidance counselor if this is a mistake. Thank you!',
                    'email_notes' => '(Automatically canceled by the system)',
                ];

                $this->mailCancelUpdate($email_data, $student->email);
            }
        }

        $approveRequests = DB::table('drop_request')->where('status', '3')->get();

        foreach ($approveRequests as $request) {
            // Parse the request date
            $requestDate = Carbon::parse($request->request_date)->startOfDay();

            // Check if the request date is before the current date
            if ($requestDate->lt($today)) {
                // Update the status to cancelled (2)
                DB::table('drop_request')
                    ->where('drop_request_id', $request->drop_request_id)
                    ->update(['status' => 4]);
            }
        }
    }

    public function viewGoodMoralList(){

        $this->autoUpdateGoodMoralRequestStatus();

        return view('admin.admin_goodMoralList');
    }

    private function autoUpdateGoodMoralRequestStatus(){
        // Get current date
        $today = Carbon::today();

        // Query all pending drop requests
        $pendingRequests = DB::table('goodmoral_request')->where('status', '1')->get();

        foreach ($pendingRequests as $request) {
            // Parse the request date
            $requestDate = Carbon::parse($request->request_date)->startOfDay();

            // Check if the request date is before the current date
            if ($requestDate->lt($today)) {
                // Update the status to cancelled (2)
                DB::table('goodmoral_request')
                    ->where('request_id', $request->request_id)
                    ->update(['status' => 2]);

                    $student = DB::table('students')->where('id', $request->student_id)->first();

                    $email_data = [
                        'subject' => 'Your good moral request has been automatically canceled by the system',
                        'email_header' => 'Student good moral request canceled',
                        'email_description' => 'Good day '. ucwords($student->firstname) .'! Your good moral request about "'.$request->reason.'" requested on '.$request->request_date.' has been automatically cancelled by the system. Please contact the guidance counselor if this is a mistake. Thank you!',
                        'email_notes' => '(Automatically canceled by the system)',
                    ];

                    $this->mailCancelUpdate($email_data, $student->email);
            }
        }

        $approveRequests = DB::table('goodmoral_request')->where('status', '3')->get();

        foreach ($approveRequests as $request) {
            // Parse the request date
            $requestDate = Carbon::parse($request->request_date)->startOfDay();

            // Check if the request date is before the current date
            if ($requestDate->lt($today)) {
                // Update the status to completed (4)
                DB::table('goodmoral_request')
                    ->where('request_id', $request->request_id)
                    ->update(['status' => 4]);
            }
        }
    }

    public function viewReports(){

        return view('admin.admin_reportList');
    }

    public function viewAppointments(){
        $this->autoUpdateAppointmentStatus();

        $events = [];

        $appointments = DB::table('appointment_request')->where('status', '3')->get();

        foreach ($appointments as $appointment) {

            $student = DB::table('students')->where('id', $appointment->student_id)->first();
            $name = $student->firstname . ' ' . $student->lastname;
            $events[] = [
                'title' => 'Subject: ' . $appointment->subject . ' (' . ucwords($name) . ' - ' . $student->email . ')',
                'start' => $appointment->appointment_date . ' ' . $appointment->appointment_time_from,
                'end' => $appointment->appointment_date . ' ' . $appointment->appointment_time_to,
            ];
        }

        return view('admin.admin_appointmentList', compact('events'));
    }

    private function autoUpdateAppointmentStatus(){
        // Get current date and time
        $now = Carbon::now();

        // Query all pending appointments
        $pendingAppointments = DB::table('appointment_request')->where('status', '1')->get();

        foreach ($pendingAppointments as $appointment) {
            // Combine appointment date and time
            $appointmentDateTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);

            // Check if the appointment date and time is in the past
            if ($appointmentDateTime->lt($now)) {
                // Update the appointment status to cancelled (2)
                DB::table('appointment_request')
                    ->where('appointment_id', $appointment->appointment_id)
                    ->update(['status' => 2]);

                    $student = DB::table('students')->where('id', $appointment->student_id)->first();

                    $email_data = [
                        'subject' => 'Your appointment request has been automatically canceled by the system',
                        'email_header' => 'Student appointment request canceled',
                        'email_description' => 'Good day '. ucwords($student->firstname) .'! Your appointment request about "'.$appointment->subject.'" requested on '.$appointment->created_at.' has been automatically cancelled by the system. Please contact the guidance counselor if this is a mistake. Thank you!',
                        'email_notes' => '(Automatically canceled by the system)',
                    ];

                    $this->mailCancelUpdate($email_data, $student->email);
            }
        }

        $approveAppointments = DB::table('appointment_request')->where('status', '3')->get();

        foreach ($approveAppointments as $appointment) {
            // Combine appointment date and time
            $appointmentDateTime = Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);

            // Check if the appointment date and time is in the past
            if ($appointmentDateTime->lt($now)) {
                // Update the appointment status to completed (4)
                DB::table('appointment_request')
                    ->where('appointment_id', $appointment->appointment_id)
                    ->update(['status' => 4]);
            }
        }
    }

    public function viewForms(){
        return view('admin.admin_forms');
    }

    public function viewSrdRecords(){
        return view('admin.admin_srdRecords');
    }

    public function viewGoodMoralCert(){
        $students = DB::table('students')->get();

        $currentDate = Carbon::now();

        $info = [
            'school_year' => ($currentDate->year - 1) . '-' . $currentDate->year,
            'date_day' => $currentDate->format('j'), // Example: '6th'
            'date_day_superscript' => $currentDate->format('S'),
            'date_month' => $currentDate->format('F'), // Example: 'July'
            'date_year' => $currentDate->format('Y'), // Example: '2024'
            'current_date' => $currentDate->format('F j, Y'),
        ];


        return view('admin.request_forms.good_moral_cert', ['info' => $info, 'students' => $students]);
    }

    public function viewHomeVisitationForm(){
        $students = DB::table('students')->get();

        $currentDate = Carbon::now();

        $info = [
            'school_year' => ($currentDate->year - 1) . '-' . $currentDate->year,
            'date_day' => $currentDate->format('j'), // Example: '6th'
            'date_day_superscript' => $currentDate->format('S'),
            'date_month' => $currentDate->format('F'), // Example: 'July'
            'date_year' => $currentDate->format('Y'), // Example: '2024'
            'current_date' => $currentDate->format('F j, Y'),
        ];

        return view('admin.request_forms.home_visitation', ['info' => $info, 'students' => $students]);
    }

    public function viewReferralForm(){
        return view('admin.request_forms.referral_form');
    }
    public function viewTravelForm(){
        return view('admin.request_forms.travel_form');
    }
    public function viewAddAccount(){
        return view('admin.admin_add_account');
    }


    private function mailCancelUpdate($data, $email){
        $layout = 'mail_layout.request_update_email';
        $subject = $data['subject'];

        try {
            Mail::to($email)->send(new Mailer($data, $layout, $subject));

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

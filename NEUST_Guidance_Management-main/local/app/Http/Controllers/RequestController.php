<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Appointments;
use App\Models\Drops;
use App\Models\GoodMorals;
use App\Models\Concerns;
use App\Models\RequestHistory;
use DateTime;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use Exception;
use Carbon\Carbon;

class RequestController extends Controller
{
    protected function getStudentData($user_id){
        return $student = Student::where('user_id', $user_id)->first();
    }

    public function submitAppointmentRequest(Request $request){

        $rules = [
            'appointmentDate' => 'required|date|after_or_equal:today',
            'appointmentTime' => 'required|date_format:H:i|after:07:59|before:17:01',
            'durationFrom' => 'required|date_format:H:i|after:07:59|before:17:01',
            'durationTo' => 'required|date_format:H:i|after:07:59|before:17:01',
            'subject' => 'required|string|max:255',
            'reason' => 'required|string|max:255'
        ];

        $messages = [
            'appointmentDate.after_or_equal' => 'Appointment date not available.',
            'appointmentTime.after' => 'Appointment time must be after 8:00 am.',
            'appointmentTime.before' => 'Appointment time must be before 5:00 pm.',
            'durationFrom.after' => 'Appointment time must be after 8:00 am.',
            'durationFrom.before' => 'Appointment time must be before 5:00 pm.',
            'durationTo.after' => 'Appointment time must be after 8:00 am.',
            'durationTo.before' => 'Appointment time must be before 5:00 pm.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dateTimeFrom = new DateTime($request->input('durationFrom'));
        $dateTimeTo = new DateTime($request->input('durationTo'));

        $timeDifference = $dateTimeFrom->diff($dateTimeTo);

        $totalMinutes = $timeDifference->i + ($timeDifference->h * 60);         //add limit min and max

        $student = $this->getStudentData(Auth::user()->id);

        $appointmentData = [
            'student_id' => $student->id,
            'appointment_date' => $request->input('appointmentDate'),
            'appointment_time' => $request->input('appointmentTime'),
            'appointment_time_from' => $request->input('durationFrom'),
            'appointment_time_to' => $request->input('durationTo'),
            'duration' => $totalMinutes,
        	'subject' => $request->input('subject'),
            'status' => 1,
            'reason' => $request->input('reason'),
            'counselor_id' => 1,
        ];


        try {
            $appointment = Appointments::create($appointmentData);

            $history = [
                'request_type' => 2,
                'request_id' => $appointment->id,
                'student_id' => $student->id,
            ];

            $status = RequestHistory::create($history);

            $email_data = [
                'subject' => 'New appointment request - Number (#'.$appointment->id.')',
                'email_header' => 'New appointment request!',
                'email_description' => 'Good day counselor! New appointment requested by '. $student->firstname. ' ' . $student->lastname . ' (' . $student->email . '). Thank you!',
                'email_notes' => 'Schedule: '. $appointment->appointment_date . ' (' . $appointment->appointment_time_from . ' - ' . $appointment->appointment_time_to . ')',
            ];

            $this->mailRequest($email_data);

            return redirect()->back()->with(['success_request' => 'You request has been submitted. Please wait for the counselor response.']);

        } catch (Exception $e) {
            // Log the exception or perform error handling
            $error = ('Error inserting: ' . $e->getMessage());

            return redirect()->back()->with(['error_request' => $error]);
        }


    }

    public function submitDropRequest(Request $request){

        $rules = [
            'requestDate' => 'required|date|after_or_equal:today',
            'reason' => 'required|string|max:255'
        ];

        $messages = [
            'requestDate.after_or_equal' => 'Appointment date not available.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = $this->getStudentData(Auth::user()->id);

        $requestData = [
            'student_id' => $student->id,
        	'request_date' => $request->input('requestDate'),
            'status' => 1,
            'reason' => $request->input('reason'),
            'counselor_id' => 1,
        ];

        try {
            $request_drop = Drops::create($requestData);

            $history = [
                'request_type' => 3,
                'request_id' => $request_drop->id,
                'student_id' => $student->id,
            ];

            $status = RequestHistory::create($history);

            $email_data = [
                'subject' => 'New student drop request - Number (#'.$request_drop->id.')',
                'email_header' => 'New student drop request!',
                'email_description' => 'Good day counselor! New dropping request by '. $student->firstname. ' ' . $student->lastname . ' (' . $student->email . '). Thank you!',
                'email_notes' => 'Student reason: ' . $request_drop->reason,
            ];

            $this->mailRequest($email_data);

            return redirect()->back()->with(['success_request' => 'You request has been submitted. Please wait for the counselor response.']);

        } catch (Exception $e) {
            // Log the exception or perform error handling
            $error = ('Error inserting: ' . $e->getMessage());

            return redirect()->back()->with(['error_request' => $error]);
        }
    }

    public function submitMoralRequest(Request $request){

        $rules = [
            'requestDate' => 'required|date|after_or_equal:today',
            'reason' => 'required|string|max:255'
        ];

        $messages = [
            'requestDate.after_or_equal' => 'Appointment date not available.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = $this->getStudentData(Auth::user()->id);

        $requestData = [
            'student_id' => $student->id,
        	'request_date' => $request->input('requestDate'),
            'status' => 1,
            'reason' => $request->input('reason'),
            'counselor_id' => 1,
        ];

        try {
            $request_gm = GoodMorals::create($requestData);

            $history = [
                'request_type' => 4,
                'request_id' => $request_gm->id,
                'student_id' => $student->id,
            ];

            $status = RequestHistory::create($history);

            $email_data = [
                'subject' => 'New good moral request - Number (#'.$request_gm->id.')',
                'email_header' => 'New good moral request!',
                'email_description' => 'Good day counselor! New good moral request by '. $student->firstname. ' ' . $student->lastname . ' (' . $student->email . '). Thank you!',
                'email_notes' => 'Student reason: ' . $request_gm->reason,
            ];

            $this->mailRequest($email_data);

            return redirect()->back()->with(['success_request' => 'You request has been submitted. Please wait for the counselor response.']);

        } catch (Exception $e) {
            // Log the exception or perform error handling
            $error = ('Error inserting: ' . $e->getMessage());

            return redirect()->back()->with(['error_request' => $error]);
        }

    }

    public function submitReportRequest(Request $request){

        $student = $this->getStudentData(Auth::user()->id);

        try {
            $request_concern = Concerns::create($request->all()); // wala validation

            $history = [
                'request_type' => 1,
                'request_id' => $request_concern->id,
                'student_id' => $student->id,
            ];

            $status = RequestHistory::create($history);

            $email_data = [
                'subject' => 'New student concern - Number (#'.$request_concern->id.')',
                'email_header' => 'New student concern!',
                'email_description' => 'Good day counselor! New student concern submitted by '. $student->firstname. ' ' . $student->lastname . ' (' . $student->email . '). Thank you!',
                'email_notes' => 'Student reason: ' . $request_concern->main_concern,
            ];

            $this->mailRequest($email_data);

            return redirect()->back()->with(['success_request' => 'You concern has been submitted. Please wait for the counselor response.']);

        } catch (Exception $e) {
            // Log the exception or perform error handling
            $error = ('Error inserting: ' . $e->getMessage());

            return redirect()->back()->with(['error_request' => $error]);
        }
    }

    public function cancelRequest(Request $request) {
        $student = $this->getStudentData(Auth::user()->id);
        $request_id = $request->input('id');
        $request_type = $request->input('request_type');

        if ($request_type == 2) {
            try {
                $status = DB::table('appointment_request')
                    ->where('student_id', $student->id)
                    ->where('appointment_id', $request_id)
                    ->where('request_type', $request_type)
                    ->update(['status' => 2]);

                $email_data = [
                    'subject' => 'Student appointment cancelled - Number (#'.$request_id.')',
                    'email_header' => 'Appointment Cancelled!',
                    'email_description' => 'Good day counselor! An appointment has been cancelled by '. $student->firstname. ' ' . $student->lastname . ' (' . $student->email . '). Thank you!',
                    'email_notes' => '',
                ];

                $this->mailRequest($email_data);

                return response()->json(['Request cancellation success!'], 200);
            } catch (Exception $e) {
                $error = ('Error cancelling: ' . $e->getMessage());
                return response()->json(['error_cancel' => $error], 500);
            }
        }
        if ($request_type == 3) {
            try {
                $status = DB::table('drop_request')
                    ->where('student_id', $student->id)
                    ->where('drop_request_id', $request_id)
                    ->where('request_type', $request_type)
                    ->update(['status' => 2]);

                $email_data = [
                    'subject' => 'Drop request cancelled - Number (#'.$request_id.')',
                    'email_header' => 'Drop Request Cancelled!',
                    'email_description' => 'Good day counselor! A drop request has been cancelled by '. $student->firstname. ' ' . $student->lastname . ' (' . $student->email . '). Thank you!',
                    'email_notes' => '',
                ];

                $this->mailRequest($email_data);

                return response()->json(['Request cancellation success!'], 200);
            } catch (Exception $e) {
                $error = ('Error cancelling: ' . $e->getMessage());
                return response()->json(['error_cancel' => $error], 500);
            }
        }

        if ($request_type == 4) {
            try {
                $status = DB::table('goodmoral_request')
                    ->where('student_id', $student->id)
                    ->where('request_id', $request_id)
                    ->where('request_type', $request_type)
                    ->update(['status' => 2]);

                $email_data = [
                    'subject' => 'Good moral request cancelled - Number (#'.$request_id.')',
                    'email_header' => 'Good Moral Request Cancelled!',
                    'email_description' => 'Good day counselor! Good moral request has been cancelled by '. $student->firstname. ' ' . $student->lastname . ' (' . $student->email . '). Thank you!',
                    'email_notes' => '',
                ];

                $this->mailRequest($email_data);

                return response()->json(['Request cancellation success!'], 200);
            } catch (Exception $e) {
                $error = ('Error cancelling: ' . $e->getMessage());
                return response()->json(['error_cancel' => $error], 500);
            }
        }

        return response()->json(['error' => 'Invalid request type.'], 400);
    }

    private function mailRequest($data){
        $layout = 'mail_layout.request_update_email';
        $subject = $data['subject'];

        try {
            Mail::to('bongabonhs@gmail.com')->send(new Mailer($data, $layout, $subject));

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}

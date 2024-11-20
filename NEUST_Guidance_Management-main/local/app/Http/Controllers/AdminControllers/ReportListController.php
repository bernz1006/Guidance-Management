<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\PDFGeneratorController;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use Exception;
use Carbon\Carbon;
use App\Models\Appointments;

class ReportListController extends Controller
{
    public function fetchReportInformation(Request $request){

        $data = DB::table('student_concern')->where('id', $request->input('id'))->first();
        $complainant = DB::table('students')->where('id', $data->complainant_id)->first();

        $victim_grade = DB::table('grade_level')->where('id', $data->victim_grade)->value('grade_level');
        $victim_section = DB::table('sections')->where('id', $data->victim_section)->value('section_name');

        $offender_grade = DB::table('grade_level')->where('id', $data->offender_grade)->value('grade_level');
        $offender_section = DB::table('sections')->where('id', $data->offender_section)->value('section_name');

        $complainant_province = DB::table('philippine_provinces')->where('province_code', $complainant->province)->value('province_description') ?? 'N/A';
        $complainant_municipality = DB::table('philippine_cities')->where('city_municipality_code', $complainant->municipality)->value('city_municipality_description') ?? 'N/A';
        $complainant_baranggay = DB::table('philippine_barangays')->where('barangay_code', $complainant->baranggay)->value('barangay_description') ?? 'N/A';

        $report_info = [
            'victim_name' => $data->victim_name,
            'victim_age' => $data->victim_age,
            'victim_gender' => $data->victim_gender,
            'victim_grade' => $victim_grade.' - '.$victim_section,
            'victim_parent_guardian' => $data->victim_parent_guardian,
            'victim_parent_contact' => $data->victim_parent_contact,
            'victim_class_adviser' => $data->victim_class_adviser,
            'complainant_name' => $complainant->firstname.' '.$complainant->middlename.' '.$complainant->lastname.' '.$complainant->suffix,
            'complainant_address' => $complainant->house_no_street.', '.$complainant_baranggay.', '.$complainant_municipality.', '.$complainant_province,
            'complainant_contact' => $complainant->contact_no,
            'relation_to_victim' => $data->relation_to_victim,
            'offender_name' => $data->offender_name,
            'offender_age' => $data->offender_age,
            'offender_gender' => $data->offender_gender,
            'offender_grade' => $offender_grade.' - '.$offender_section,
            'offender_parent_guardian' => $data->offender_parent_guardian,
            'offender_parent_contact' => $data->offender_parent_contact,
            'offender_class_adviser' => $data->offender_class_adviser,
            'main_concern' => $data->main_concern,
            'action_taken' => $data->action_taken,
            'recommendation' => $data->recommendation,
        ];

        return response()->json($report_info);
    }


    public function updateStudentConcern(Request $request){

        $complaint = DB::table('student_concern')->where('id', $request->input('concern_id'))->first();
        $student = DB::table('students')->where('id', $complaint->complainant_id)->first();

        $concern_data = [
            'action_taken' => $request->input('actiontaken'),
            'recommendation' => $request->input('rec'),
            'status' => 3,
        ];

        $email_data = [
            'subject' => 'Your concern has been approved by the counselor',
            'email_header' => 'Student concern approved',
            'email_description' => 'Good day '. ucwords($student->firstname) .'! Your concern about "'.$complaint->main_concern.'" has been approved by the guidance counselor. Please check your account for the details of your appointment. Thank you!',
            'email_notes' => '',
        ];

        try{
            $status = DB::table('student_concern')->where('id', $request->input('concern_id'))->update($concern_data);

            $this->mailConcernUpdate($email_data, $student->email);

            if($complaint->hasAppointment == 0){
                $available_schedule = $this->checkAvailableSchedule();

                $appointmentData = [
                    'student_id' => $student->id,
                    'appointment_date' => $available_schedule['date'],
                    'appointment_time' => $available_schedule['time'],
                    'appointment_time_from' => $available_schedule['time'],
                    'appointment_time_to' => $available_schedule['endTime'],
                    'duration' => $available_schedule['totalMinutes'],
                    'subject' => 'Appointment from student concern: "'.$complaint->main_concern.'"',
                    'status' => 1,
                    'reason' => $complaint->main_concern,
                    'counselor_id' => 1,
                ];

                $appointment = Appointments::create($appointmentData);
                $update_appointment_status = DB::table('student_concern')->where('id', $request->input('concern_id'))->update(['hasAppointment' => '1']);
            }

        }catch(Exception $e){
            dd($e);
            return redirect()->back()->with('error_update', 'Processing action failed! Please try again.');
        }

        if($status){
            $update_time = DB::table('student_concern')->where('id', $request->input('concern_id'))->update(['updated_at' => now()]);

            return redirect()->back()->with('status_update', 'Action taken successfully! Email sent to the student and appointment set.');
        }else{
            return redirect()->back()->with('status_no_update', 'No changes made. Email sent to the student.');
        }
    }

    private function checkAvailableSchedule(){
        // Retrieve the latest approved appointment
        $latestApprovedAppointment = DB::table('appointment_request')
            ->where('status', 3) // Approved appointments
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->first();

        // If there is no approved appointment, set the appointment for tomorrow at 7:30 AM
        if (!$latestApprovedAppointment) {
            $tomorrow = Carbon::tomorrow();
            $start_time = $tomorrow->copy()->setTime(7, 30, 0);
            $end_time = $start_time->copy()->addHour();

            return [
                'date' => $tomorrow->toDateString(),
                'time' => $start_time->toTimeString(),
                'endTime' => $end_time->toTimeString(),
                'totalMinutes' => $start_time->diffInMinutes($end_time)
            ];
        }

        // Get the appointment date and time
        $date = Carbon::parse($latestApprovedAppointment->appointment_date);
        $startTime = Carbon::parse($latestApprovedAppointment->appointment_time_from);
        $endTime = Carbon::parse($latestApprovedAppointment->appointment_time_to);

        // Check if the end time exceeds 5:00 PM
        $endOfWorkingHours = Carbon::parse('17:00:00'); // 5:00 PM
        if ($endTime->greaterThanOrEqualTo($endOfWorkingHours)) {
            // Set the appointment for tomorrow at 7:30 AM
            $tomorrow = $date->copy()->addDay();
            $start_time = $tomorrow->copy()->setTime(7, 30, 0);
            $end_time = $start_time->copy()->addHour();

            return [
                'date' => $tomorrow->toDateString(),
                'time' => $start_time->toTimeString(),
                'endTime' => $end_time->toTimeString(),
                'totalMinutes' => $start_time->diffInMinutes($end_time)
            ];
        }

        // Calculate total minutes between start and end time
        $totalMinutes = $startTime->diffInMinutes($endTime);

        // Prepare the available schedule
        $available_schedule = [
            'date' => $date->toDateString(),
            'time' => $endTime->toTimeString(),
            'endTime' => $endTime->copy()->addHour()->toTimeString(),
            'totalMinutes' => $totalMinutes
        ];

        // Return the new appointment date and time
        return $available_schedule;
    }

    public function updateConcernStatus(Request $request){
        $complaint = DB::table('student_concern')->where('id', $request->input('concern_id'))->first();
        $student = DB::table('students')->where('id', $complaint->complainant_id)->first();

        $status = DB::table('student_concern')->where('id', $request->input('concern_id'))->update(['status' => $request->input('id')]);

        if($request->input('id') == 1){

            $response = 'Student concern has been updated into pending.';

        }else if($request->input('id') == 2){

            $response = 'Student concern has been cancelled. Email sent to the student!';

            $email_data = [
                'subject' => 'Your concern has been cancelled by the counselor',
                'email_header' => 'Student concern cancelled',
                'email_description' => 'Good day '. ucwords($student->firstname) .'! Your concern about "'.$complaint->main_concern.'" has been cancelled by the guidance counselor. Please contact the guidance counselor if this is a mistake. Thank you!',
                'email_notes' => '',
            ];

            $this->mailConcernUpdate($email_data, $student->email);

        }else if($request->input('id') == 4){

            $response = 'Student concern marked as completed. Email sent to the student!';

            $email_data = [
                'subject' => 'Your concern has been completed by the counselor',
                'email_header' => 'Student concern completed',
                'email_description' => 'Good day '. ucwords($student->firstname) .'! Your concern about "'.$complaint->main_concern.'" has been completed by the guidance counselor. Please contact the guidance counselor if this is a mistake. Thank you!',
                'email_notes' => '',
            ];

            $this->mailConcernUpdate($email_data, $student->email);
        }

        if($status){
            $update_time = DB::table('student_concern')->where('id', $request->input('concern_id'))->update(['updated_at' => now()]);
            return response()->json($response);
        }else{
            return response()->json('Error');
        }
    }

    public function downloadConcernInformation(Request $request){
        $data = DB::table('student_concern')->where('id', $request->input('id'))->first();
        $complainant = DB::table('students')->where('id', $data->complainant_id)->first();

        $victim_grade = DB::table('grade_level')->where('id', $data->victim_grade)->value('grade_level');
        $victim_section = DB::table('sections')->where('id', $data->victim_section)->value('section_name');

        $offender_grade = DB::table('grade_level')->where('id', $data->offender_grade)->value('grade_level');
        $offender_section = DB::table('sections')->where('id', $data->offender_section)->value('section_name');

        $complainant_province = DB::table('philippine_provinces')->where('province_code', $complainant->province)->value('province_description') ?? 'N/A';
        $complainant_municipality = DB::table('philippine_cities')->where('city_municipality_code', $complainant->municipality)->value('city_municipality_description') ?? 'N/A';
        $complainant_baranggay = DB::table('philippine_barangays')->where('barangay_code', $complainant->baranggay)->value('barangay_description') ?? 'N/A';

        $report_info = [
            'victim_name' => $data->victim_name,
            'victim_age' => $data->victim_age,
            'victim_gender' => $data->victim_gender,
            'victim_grade' => $victim_grade.' - '.$victim_section,
            'victim_parent_guardian' => $data->victim_parent_guardian,
            'victim_parent_contact' => $data->victim_parent_contact,
            'victim_class_adviser' => $data->victim_class_adviser,
            'complainant_name' => $complainant->firstname.' '.$complainant->middlename.' '.$complainant->lastname.' '.$complainant->suffix,
            'complainant_address' => $complainant->house_no_street.', '.$complainant_baranggay.', '.$complainant_municipality.', '.$complainant_province,
            'complainant_contact' => $complainant->contact_no,
            'relation_to_victim' => $data->relation_to_victim,
            'offender_name' => $data->offender_name,
            'offender_age' => $data->offender_age,
            'offender_gender' => $data->offender_gender,
            'offender_grade' => $offender_grade.' - '.$offender_section,
            'offender_parent_guardian' => $data->offender_parent_guardian,
            'offender_parent_contact' => $data->offender_parent_contact,
            'offender_class_adviser' => $data->offender_class_adviser,
            'main_concern' => $data->main_concern,
            'action_taken' => $data->action_taken,
            'recommendation' => $data->recommendation,
        ];

        $filename = 'report_info.pdf';
        $layout = 'pdf_layout.pdf_report_info';

        try {
            $pdfGenerator = new PDFGeneratorController();
            return $pdfGenerator->generatePdf($report_info, $layout, $filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function removeStudentConcern(Request $request){
        $status = DB::table('student_concern')->where('id', $request->input('id'))->delete();

        if($status){
            return response()->json('Student concern has been deleted.');
        }else{
            return response()->json('Error');
        }
    }

    private function mailConcernUpdate($data, $email){
        $layout = 'mail_layout.request_update_email';
        $subject = $data['subject'];

        try {
            Mail::to($email)->send(new Mailer($data, $layout, $subject));

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

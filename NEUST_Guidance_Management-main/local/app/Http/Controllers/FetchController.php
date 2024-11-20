<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointments;
use App\Models\Drops;
use App\Models\GoodMorals;
use App\Models\Concerns;
use App\Models\RequestType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;

class FetchController extends Controller
{
    protected function getStudentData($user_id){
        return $student = Student::where('user_id', $user_id)->first();
    }

    //fetch for users
    public function fetchAppointmentRequest(Request $request){
        if ($request->ajax()) {

            $student = $this->getStudentData(Auth::user()->id);

            if ($student) {
                $user_appointments = Appointments::where('student_id', $student->id)->orderBy('created_at', 'desc')->get();

                return DataTables::of($user_appointments)
                    ->addIndexColumn()
                    ->addColumn('appointment_status', function($row){
                        $status = DB::table('status')->where('id', $row->status)->value('status');
                        if($row->status == 1){
                            $appointment_status = $status.' '.
                            '<div class="spinner-border spinner-border-sm text-secondary" role="status">
                            </div>';
                        }else if($row->status == 2){
                            $appointment_status = $status.' '.
                            '<div class="spinner-grow bg-transparent text-danger" role="status">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>';
                        }else if($row->status == 3){
                            $appointment_status = $status.' '.
                            '<div class="spinner-grow bg-transparent text-success" role="status">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>';
                        }else if($row->status == 4){
                            $appointment_status = $status.' '.
                            '<div class="spinner-grow bg-transparent text-primary" role="status">
                                <i class="bi bi-check-circle-fill">
                                </i>
                            </div>';
                        }

                        return $appointment_status;
                    })
                    ->addColumn('formatted_appointment_date', function($row){
                        // Your date string
                        $date = $row->appointment_date;

                        // Create a Carbon instance and format it
                        $formatted_appointment_date = Carbon::parse($date)->format('F j, Y');

                        return $formatted_appointment_date;
                    })
                    ->addColumn('formatted_appointment_time', function($row){
                        // Your date string
                        $date = $row->appointment_time;

                        // Create a Carbon instance and format it
                        $formatted_appointment_time = Carbon::parse($date)->format('g:i a');

                        return $formatted_appointment_time;
                    })
                    ->addColumn('formatted_appointment_time_from', function($row){
                        // Your date string
                        $date = $row->appointment_time_from;

                        // Create a Carbon instance and format it
                        $formatted_appointment_time_from = Carbon::parse($date)->format('g:i a');

                        return $formatted_appointment_time_from;
                    })
                    ->addColumn('formatted_appointment_time_to', function($row){
                        // Your date string
                        $date = $row->appointment_time_to;

                        // Create a Carbon instance and format it
                        $formatted_appointment_time_to = Carbon::parse($date)->format('g:i a');

                        return $formatted_appointment_time_to;
                    })
                    ->addColumn('duration', function($row){

                        return $row->duration.' '.'minutes';
                    })
                    ->addColumn('formatted_requested_date', function($row){
                        $date = $row->created_at;

                        $formatted_requested_date = Carbon::parse($date)->format('F j, Y g:i:s a');

                        return $formatted_requested_date;
                    })
                    ->addColumn('cancel_btn', function($row){
                        if($row->status == '1'){
                            $cancel_btn = '<button data-id="'.$row->appointment_id.'" id="cancel_req_btn" class="btn btn-danger"><i class="bi bi-x-circle" style="color: white;"></i></button>';
                        }else{
                            $cancel_btn = '<button data-id="'.$row->appointment_id.'" id="cancel_req_btn" class="btn btn-danger" disabled><i class="bi bi-x-circle" style="color: white;"></i></button>';
                        }

                        return $cancel_btn;
                    })
                    ->rawColumns(['appointment_status', 'cancel_btn'])
                    ->make(true);
            } else {
                return response()->json(['error' => 'Student data not found'], 404);
            }
        }
    }

    public function fetchDropRequest(Request $request){
        if ($request->ajax()) {

            $student = $this->getStudentData(Auth::user()->id);

            if ($student) {
                $user_drops = Drops::where('student_id', $student->id)->orderBy('created_at', 'desc')->get();

                return DataTables::of($user_drops)
                    ->addIndexColumn()
                    ->addColumn('appointment_status', function($row){
                        $status = DB::table('status')->where('id', $row->status)->value('status');
                        if($row->status == 1){
                            $appointment_status = $status.' '.
                            '<div class="spinner-border spinner-border-sm text-secondary" role="status">
                            </div>';
                        }else if($row->status == 2){
                            $appointment_status = $status.' '.
                            '<div class="spinner-grow bg-transparent text-danger" role="status">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>';
                        }else if($row->status == 3){
                            $appointment_status = $status.' '.
                            '<div class="spinner-grow bg-transparent text-success" role="status">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            ';
                        }else if($row->status == 4){
                            $appointment_status = $status.' '.
                            '<div class="spinner-grow bg-transparent text-primary" role="status">
                                <i class="bi bi-check-circle-fill">
                                </i>
                            </div>
                            ';
                        }

                        return $appointment_status;
                    })
                    ->addColumn('formatted_request_date', function($row){
                        $date = $row->request_date;

                        $formatted_requested_date = Carbon::parse($date)->format('F j, Y');

                        return $formatted_requested_date;
                    })
                    ->addColumn('notes', function($row){
                        $note = $row->notes;

                        if($row->status == 2){
                            return '(Cancelled)';
                        }

                        if($note == NULL){
                            return '(To be updated)';
                        }

                        return $note;
                    })
                    ->addColumn('formatted_request_on', function($row){
                        $date = $row->created_at;

                        $formatted_requested_on = Carbon::parse($date)->format('F j, Y g:i a');

                        return $formatted_requested_on;
                    })
                    ->addColumn('cancel_btn', function($row){
                        if($row->status == '1'){
                            $cancel_btn = '<button data-id="'.$row->drop_request_id.'" id="cancel_req_btn" class="btn btn-danger"><i class="bi bi-x-circle" style="color: white;"></i></button>';
                        }else{
                            $cancel_btn = '<button data-id="'.$row->drop_request_id.'" id="cancel_req_btn" class="btn btn-danger" disabled><i class="bi bi-x-circle" style="color: white;"></i></button>';
                        }

                        return $cancel_btn;
                    })
                    ->rawColumns(['appointment_status', 'cancel_btn'])
                    ->make(true);
            } else {
                return response()->json(['error' => 'Student data not found'], 404);
            }
        }
    }
    public function fetchGoodMoralRequest(Request $request){
        if ($request->ajax()) {

            $student = $this->getStudentData(Auth::user()->id);

            if ($student) {
                $user_gm_request = GoodMorals::where('student_id', $student->id)->orderBy('created_at', 'desc')->get();

                return DataTables::of($user_gm_request)
                    ->addIndexColumn()
                    ->addColumn('appointment_status', function($row){
                        $status = DB::table('status')->where('id', $row->status)->value('status');
                        if($row->status == 1){
                            $appointment_status = $status.' '.
                            '<div class="spinner-border spinner-border-sm text-secondary" role="status">
                            </div>';
                        }else if($row->status == 2){
                            $appointment_status = $status.' '.
                            '<div class="spinner-grow bg-transparent text-danger" role="status">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>';
                        }else if($row->status == 3){
                            $appointment_status = $status.' '.
                            '<div class="spinner-grow bg-transparent text-success" role="status">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <small class="text-primary">(Requested document already emailed by the counselor. <a style="text-decoration: underline;" href="https://mail.google.com/mail/u/0/#inbox" target="_blank">Check here</a>)</small>
                            ';
                        }else if($row->status == 4){
                            $appointment_status = $status.' '.
                            '<div class="spinner-grow bg-transparent text-primary" role="status">
                                <i class="bi bi-check-circle-fill">
                                </i>
                            </div>
                            <small class="text-primary">(Requested document already emailed by the counselor. <a style="text-decoration: underline;" href="https://mail.google.com/mail/u/0/#inbox" target="_blank">Check here</a>)</small>
                            ';
                        }

                        return $appointment_status;
                    })
                    ->addColumn('rowClass', function ($row) {
                        if ($row->status == 1) {
                            return 'status-blue';
                        } elseif ($row->status == 2) {
                            return 'status-red';
                        } elseif ($row->status == 3 || $row->status == 4) {
                            return 'status-green';
                        }
                        return '';
                    }) 
                    ->addColumn('formatted_request_date', function($row){
                        $date = $row->request_date;

                        $formatted_requested_date = Carbon::parse($date)->format('F j, Y');

                        return $formatted_requested_date;
                    })
                    ->addColumn('notes', function($row){
                        $note = $row->notes;

                        if($row->status == 2){
                            return '(Cancelled)';
                        }

                        if($note == NULL){
                            return '(To be updated)';
                        }

                        return $note;
                    })
                    ->addColumn('formatted_request_on', function($row){
                        $date = $row->created_at;

                        $formatted_requested_date = Carbon::parse($date)->format('F j, Y g:i a');

                        return $formatted_requested_date;
                    })
                    ->addColumn('cancel_btn', function($row){
                        if($row->status == '1'){
                            $cancel_btn = '<button data-id="'.$row->request_id.'" id="cancel_req_btn" class="btn btn-danger"><i class="bi bi-x-circle" style="color: white;"></i></button>';
                        }else{
                            $cancel_btn = '<button data-id="'.$row->request_id.'" id="cancel_req_btn" class="btn btn-danger" disabled><i class="bi bi-x-circle" style="color: white;"></i></button>';
                        }

                        return $cancel_btn;
                    })
                    ->rawColumns(['appointment_status', 'cancel_btn'])
                    ->make(true);
            } else {
                return response()->json(['error' => 'Student data not found'], 404);
            }
        }
    }

    public function fetchImage($id)
    {
        $student = DB::table('students')->where('id', $id)->first();

        if ($student && !empty($student->student_img)) {
            return response($student->student_img)->header('Content-Type', 'image/jpeg');
        }

        return response('No Image', 200)->header('Content-Type', 'text/plain');
    }

    public function fetchSections($grade){
        $sections = DB::table('sections')->where('grade_id', $grade)->get();

        return response()->json($sections);
    }

    public function fetchGradeLevel(){
        $grade_levels = DB::table('grade_level')->get();

        return response()->json($grade_levels);
    }

    public function fetchAdvisers(){
        $advisers = DB::table('advisers')->get();

        return response()->json($advisers);
    }


    public function fetchStudentInformation($id)
    {

        $student = DB::table('students')->where('id', $id)->first();
        $current_grade = DB::table('grade_level')->where('id', $student->current_grade)->value('grade_level');
        $current_section = DB::table('sections')->where('id', $student->current_section)->value('section_name');
        $adviser = DB::table('advisers')->where('id', $student->adviser)->value('adviser_name');
        $birthday = Carbon::createFromFormat('Y-m-d', $student->birthday)->format('F j, Y');
        $last_update =  Carbon::parse($student->updated_at)->format('F j, Y'). ' at ' .Carbon::parse($student->updated_at)->format('g:i a');
        $birthDateCarbon = Carbon::createFromFormat('Y-m-d', $student->birthday);

        $currentDate = Carbon::now();
        $currentYear = $currentDate->format('y');
        $student_age = $birthDateCarbon->diffInYears($currentDate);

        $student_province = DB::table('philippine_provinces')->where('province_code', $student->province)->value('province_description') ?? '(To be updated)';
        $student_municipality = DB::table('philippine_cities')->where('city_municipality_code', $student->municipality)->value('city_municipality_description') ?? '(To be updated)';
        $student_baranggay = DB::table('philippine_barangays')->where('barangay_code', $student->baranggay)->value('barangay_description') ?? '(To be updated)';

        $student_info = [
            'id' => $student->id,
            'email' => $student->email,
            'firstname' => $student->firstname,
            'middlename' => $student->middlename,
            'lastname' => $student->lastname,
            'suffix' => $student->suffix,
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
            'father_contact' => $student->father_contact,
            'father_occupation' => $student->father_occupation,
            'mother' => $student->mother,
            'mother_contact' => $student->mother_contact,
            'mother_occupation' => $student->mother_occupation,
            'living_with' => $student->living_with,
            'no_of_siblings' => $student->no_of_siblings,
            'position' => $student->position,
            'elem_school' => $student->elem_school,
            'school_id' => $student->school_id,
            'gen_average' => $student->gen_average,
            'current_grade' => $current_grade,
            'current_grade_id' => $student->current_grade,
            'current_section' => $current_section,
            'current_section_id' => $student->current_section,
            'adviser' => $adviser,
            'adviser_id' => $student->adviser,
            'last_update' => $last_update,
        ];

        return response()->json($student_info);
    }

    //fetch for counselor
    public function fetchStudentsAll(Request $request){
        if ($request->ajax()) {

            $students = DB::table('students')->get();

            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('fullname', function ($row) {
                    $name = $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname;
                    return ucwords($name);
                })
                ->addColumn('profile_image', function ($row) {
                    $url = route('student.image', ['id' => $row->id]);
                    $profile = '<img src="' . $url . '" width="50" height="50" style="object-fit: cover;"/>';

                    return !is_null($row->student_img) ? $profile : '<img src="' . asset('img/default.jpg') . '" width="50" height="50" style="object-fit: cover;"/>';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                                <button class="btn" id="student_editor_btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#student_editor_modal" style="background-color:  #ffc107;color:#fff;"><i class="bi bi-pencil-square" style="color: white;"></i></button>
                                <button class="btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#student_info_modal" style="background-color:  #20c997;color:#fff;"><i class="bi bi-eye" style="color: white;"></i></button>
                                <button disabled id="email_student_btn" class="btn btn-secondary" data-id="'.$row->id.'"><i class="bi bi-send" style="color: white;"></i></button>
                                <button id="download_info_btn" class="btn btn-secondary" data-id="'.$row->id.'"><i class="bi bi-file-earmark-arrow-down-fill" style="color: white;"></i></button>
                                ';

                    $student = Student::find($row->id);

                    if ($student) {
                        $attributes = collect($student->getAttributes())->except('middlename', 'suffix');
                        if ($attributes->contains(function ($value) {
                            return is_null($value);
                        })) {
                            $actionBtn = '
                            <button class="btn" id="student_editor_btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#student_editor_modal" style="background-color:  #ffc107;color:#fff;"><i class="bi bi-pencil-square" style="color: white;"></i></button>
                            <button class="btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#student_info_modal" style="background-color:  #20c997;color:#fff;"><i class="bi bi-eye" style="color: white;"></i></button>
                            <button id="email_student_btn" class="btn btn-secondary" data-id="'.$row->id.'"><i class="bi bi-send" style="color: white;"></i></button>
                            <button disabled id="download_info_btn" class="btn btn-secondary" data-id="'.$row->id.'"><i class="bi bi-file-earmark-arrow-down-fill" style="color: white;"></i></button>
                            ';
                        }
                    }
                    return $actionBtn;
                })
                ->addColumn('profile_status', function($row){
                    $status = '<b class="text-primary">Completed</b>';
                    $student = Student::find($row->id);

                    if ($student) {
                        $attributes = collect($student->getAttributes())->except('middlename', 'suffix');
                        if ($attributes->contains(function ($value) {
                            return is_null($value);
                        })) {
                            $status = '<b class="text-danger">Need to update</b>';
                        }
                    }

                    return $status;
                })
                ->rawColumns(['action', 'fullname', 'profile_status', 'profile_image'])
                ->make(true);
        }
    }

    public function fetchReports(Request $request){
        if ($request->ajax()) {

            $reports = Concerns::orderBy('created_at', 'desc');

            return DataTables::of($reports)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $list_of_status = DB::table('status')->get();
                    $downloadable = 'disabled';
                    if($row->status == 3 || $row->status == 4){
                        $downloadable = '';
                    }
                    $actionBtn = '
                        <div class="d-flex gap-1">
                            <div class="dropdown-center">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-pencil-square" style="color: white;"></i>
                                </button>
                                <ul class="dropdown-menu">';

                    foreach ($list_of_status as $status) {
                        $disabled = false;
                        $disabledStyle = ' style="pointer-events: none; cursor: not-allowed; background-color: #ddd; color: #fff;"';

                        if (($row->status == 1 && $status->id == 4) ||
                            ($row->status == 2 && in_array($status->id, [1, 2, 3, 4])) ||
                            ($row->status == 3 && in_array($status->id, [1, 2])) ||
                            ($row->status == 4 && in_array($status->id, [1, 2, 3, 4]))) {
                            $disabled = true;
                        }

                        if ($disabled) {
                            $actionBtn .= '<li><a data-id="'.$status->id.'" class="dropdown-item" href="#"' . $disabledStyle . '>' . $status->status_pre . '</a></li>';
                        } else {
                            if($status->id == 3){
                                $actionBtn .= '<li><a data-bs-toggle="modal" data-bs-target="#concern_editor" data-concernid="'.$row->id.'" data-id="'.$status->id.'" data-name="'.$status->status.'" class="dropdown-item" href="#">' . $status->status_pre . '</a></li>';
                            }else{
                                if($row->status == $status->id){
                                    $actionBtn .= '<li><a data-concernid="'.$row->id.'" data-id="'.$status->id.'" data-name="'.$status->status.'" class="dropdown-item" href="#" style="pointer-events: none; cursor: not-allowed;">' . $status->status_pre . '</a></li>';
                                }else{
                                    $actionBtn .= '<li><a id="update_status_btn" data-concernid="'.$row->id.'" data-id="'.$status->id.'" data-name="'.$status->status.'" class="dropdown-item" href="#">' . $status->status_pre . '</a></li>';
                                }
                            }
                        }
                    }

                    $actionBtn .= '
                                </ul>
                            </div>
                            <button class="btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#student_concern_modal" style="background-color:  #20c997;color:#fff;"><i class="bi bi-eye" style="color: white;"></i></button>
                            <button id="download_report_info" class="btn btn-secondary" data-id="'.$row->id.'" '.$downloadable.'><i class="bi bi-file-earmark-arrow-down-fill" style="color: white;"></i></button>
                            <button id="delete_report_btn" data-id="'.$row->id.'" class="btn btn-danger"><i class="bi bi-trash" style="color: white;"></i></button>
                        </div>';
                    return $actionBtn;
                })
                ->addColumn('report_status', function($row){
                    $status = DB::table('status')->where('id', $row->status)->value('status');
                    if($row->status == 1){
                        $report_status = $status;
                    }else if($row->status == 2){
                        $report_status = $status;
                    }else if($row->status == 3){
                        $report_status = $status;
                    }else if($row->status == 4){
                        $report_status = $status;
                    }

                    return $report_status;
                })
                ->addColumn('rowClass', function ($row) {
                    if ($row->status == 1) {
                        return 'status-gray';
                    } elseif ($row->status == 2) {
                        return 'status-red';
                    } elseif ($row->status == 3) {
                        return 'status-blue';
                    } elseif ($row->status == 4) {
                        return 'status-green';
                    }
                    return '';
                })                              
                ->addColumn('formatted_requested_date', function($row){
                    $date = $row->created_at;

                    $formatted_requested_date = Carbon::parse($date)->format('F j, Y g:i a');

                    return $formatted_requested_date;
                })
                ->rawColumns(['action', 'report_status'])
                ->make(true);
        }
    }

    public function fetchDropRequest2(Request $request){
        if ($request->ajax()) {

            $drop_requests = Drops::where('isActive', 1)->orderBy('request_date', 'desc')->get();

            return DataTables::of($drop_requests)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $list_of_status = DB::table('status')->get();
                    $downloadable = 'disabled';
                    if($row->status == 3 || $row->status == 4){
                        $downloadable = '';
                    }
                    $actionBtn = '
                        <div class="d-flex gap-1">
                            <div class="dropdown-center">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-pencil-square" style="color: white;"></i>
                                </button>
                                <ul class="dropdown-menu">';

                    foreach ($list_of_status as $status) {
                        $disabled = false;
                        $disabledStyle = ' style="pointer-events: none; cursor: not-allowed; background-color: #ddd; color: #fff;"';

                        if (($row->status == 1 && $status->id == 4) ||
                            ($row->status == 2 && in_array($status->id, [1, 2, 3, 4])) ||
                            ($row->status == 3 && in_array($status->id, [1, 2])) ||
                            ($row->status == 4 && in_array($status->id, [1, 2, 3, 4]))) {
                            $disabled = true;
                        }

                        if ($disabled) {
                            $actionBtn .= '<li><a data-id="'.$status->id.'" class="dropdown-item" href="#"' . $disabledStyle . '>' . $status->status_pre . '</a></li>';
                        } else {
                            if($status->id == 3){
                                $actionBtn .= '<li><a id="approve_status_btn" data-drop="'.$row->drop_request_id.'" data-notes="'.$row->notes.'" data-id="'.$status->id.'" class="dropdown-item" href="#">' . $status->status_pre . '</a></li>';
                            }else{
                                if($row->status == $status->id){
                                    $actionBtn .= '<li><a data-drop="'.$row->drop_request_id.'" data-id="'.$status->id.'" data-name="'.$status->status.'" class="dropdown-item" href="#" style="pointer-events: none; cursor: not-allowed;">' . $status->status_pre . '</a></li>';
                                }else{
                                    $actionBtn .= '<li><a id="update_status_btn" data-drop="'.$row->drop_request_id.'" data-id="'.$status->id.'" data-name="'.$status->status.'" class="dropdown-item" href="#">' . $status->status_pre . '</a></li>';
                                }
                            }
                        }
                    }

                    $actionBtn .= '
                                </ul>
                            </div>
                            <button class="btn btn-primary" data-id="'.$row->student_id.'" data-bs-toggle="modal" data-bs-target="#student_info_modal" style="color:#fff;"><i class="bi bi-person-fill" style="color: white;"></i></button>
                            <button id="download_drop_form" class="btn btn-secondary" data-id="'.$row->drop_request_id.'" disabled><i class="bi bi-file-earmark-arrow-down-fill" style="color: white;"></i></button>
                            <button id="archive_drop_item" data-id="'.$row->drop_request_id.'" class="btn btn-danger"><i class="bi bi-archive" style="color: white;"></i></button>
                        </div>';
                    return $actionBtn;
                })
                ->addColumn('drop_status', function($row){
                    $status = DB::table('status')->where('id', $row->status)->value('status');
                    if($row->status == 1){
                        $drop_status = $status;
                    }else if($row->status == 2){
                        $drop_status = $status;
                    }else if($row->status == 3){
                        $drop_status = $status;
                    }else if($row->status == 4){
                        $drop_status = $status;
                    }

                    return $drop_status;
                })
                ->addColumn('rowClass', function ($row) {
                    if ($row->status == 1) {
                        return 'status-gray';
                    } elseif ($row->status == 2) {
                        return 'status-red';
                    } elseif ($row->status == 3) {
                        return 'status-blue';
                    } elseif ($row->status == 4) {
                        return 'status-green';
                    }
                    return '';
                }) 
                ->addColumn('formatted_requested_date', function($row){
                    $date = $row->request_date;

                    $formatted_requested_date = Carbon::parse($date)->format('F j, Y');

                    return $formatted_requested_date;
                })
                ->addColumn('student_name', function($row){
                    $student = DB::table('students')->where('id', $row->student_id)->first();

                    return ucwords($student->firstname.' '.$student->middlename.' '.$student->lastname.' '.$student->suffix);
                })
                ->rawColumns(['action', 'drop_status'])
                ->make(true);
        }
    }

    public function fetchGoodMoralRequest2(Request $request){
        if ($request->ajax()) {

            $good_morals = GoodMorals::where('isActive', 1)->orderBy('request_date', 'desc')->get();

            return DataTables::of($good_morals)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $list_of_status = DB::table('status')->get();
                    $downloadable = 'disabled';
                    if($row->status == 3 || $row->status == 4){
                        $downloadable = '';
                    }
                    $actionBtn = '
                        <div class="d-flex gap-1">
                            <div class="dropdown-center">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-pencil-square" style="color: white;"></i>
                                </button>
                                <ul class="dropdown-menu">';

                    foreach ($list_of_status as $status) {
                        $disabled = false;
                        $disabledStyle = ' style="pointer-events: none; cursor: not-allowed; background-color: #ddd; color: #fff;"';

                        if (($row->status == 1 && $status->id == 4) ||
                            ($row->status == 2 && in_array($status->id, [1, 2, 3, 4])) ||
                            ($row->status == 3 && in_array($status->id, [1, 2])) ||
                            ($row->status == 4 && in_array($status->id, [1, 2, 3, 4]))) {
                            $disabled = true;
                        }

                        if ($disabled) {
                            $actionBtn .= '<li><a data-id="'.$status->id.'" class="dropdown-item" href="#"' . $disabledStyle . '>' . $status->status_pre . '</a></li>';
                        } else {
                            if($status->id == 3){
                                $actionBtn .= '<li><a id="approve_status_btn" data-gm="'.$row->request_id.'" data-notes="'.$row->notes.'" data-id="'.$status->id.'" class="dropdown-item" href="#">' . $status->status_pre . '</a></li>';
                            }else{
                                if($row->status == $status->id){
                                    $actionBtn .= '<li><a data-gm="'.$row->request_id.'" data-id="'.$status->id.'" data-name="'.$status->status.'" class="dropdown-item" href="#" style="pointer-events: none; cursor: not-allowed;">' . $status->status_pre . '</a></li>';
                                }else{
                                    $actionBtn .= '<li><a id="update_status_btn" data-gm="'.$row->request_id.'" data-id="'.$status->id.'" data-name="'.$status->status.'" class="dropdown-item" href="#">' . $status->status_pre . '</a></li>';
                                }
                            }
                        }
                    }

                    $actionBtn .= '
                                </ul>
                            </div>
                            <button class="btn btn-primary" data-id="'.$row->student_id.'" data-bs-toggle="modal" data-bs-target="#student_info_modal" style="color:#fff;"><i class="bi bi-person-fill" style="color: white;"></i></button>
                            <button id="download_gm_form" class="btn btn-secondary" data-id="'.$row->request_id.'" '.$downloadable.'><i class="bi bi-file-earmark-arrow-down-fill" style="color: white;"></i></button>
                            <button id="archive_gm_item" data-id="'.$row->request_id.'" class="btn btn-danger"><i class="bi bi-archive" style="color: white;"></i></button>
                        </div>';
                    return $actionBtn;
                })
                ->addColumn('gm_status', function($row){
                    $status = DB::table('status')->where('id', $row->status)->value('status');
                    if($row->status == 1){
                        $gm_status = $status;
                    }else if($row->status == 2){
                        $gm_status = $status;
                    }else if($row->status == 3){
                        $gm_status = $status;
                    }else if($row->status == 4){
                        $gm_status = $status;
                    }

                    return $gm_status;
                })
                ->addColumn('rowClass', function ($row) {
                    if ($row->status == 1) {
                        return 'status-gray';
                    } elseif ($row->status == 2) {
                        return 'status-red';
                    } elseif ($row->status == 3) {
                        return 'status-blue';
                    } elseif ($row->status == 4) {
                        return 'status-green';
                    }
                    return '';
                }) 
                ->addColumn('formatted_requested_date', function($row){
                    $date = $row->request_date;

                    $formatted_requested_date = Carbon::parse($date)->format('F j, Y');

                    return $formatted_requested_date;
                })
                ->addColumn('student_name', function($row){
                    $student = DB::table('students')->where('id', $row->student_id)->first();

                    return ucwords($student->firstname.' '.$student->middlename.' '.$student->lastname.' '.$student->suffix);
                })
                ->rawColumns(['action', 'gm_status'])
                ->make(true);
        }
    }

    public function fetchAppointmentRequest2(Request $request){
        if ($request->ajax()) {

            $requests = Appointments::orderBy('created_at', 'desc')->get();

            return DataTables::of($requests)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $list_of_status = DB::table('status')->get();
                    $email_available = 'disabled';
                    if($row->status == 3){
                        $email_available = '';
                    }
                    $actionBtn = '
                        <div class="d-flex gap-1">
                            <div class="dropdown-center">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-pencil-square" style="color: white;"></i>
                                </button>
                                <ul class="dropdown-menu">';

                    foreach ($list_of_status as $status) {
                        $disabled = false;
                        $disabledStyle = ' style="pointer-events: none; cursor: not-allowed; background-color: #ddd; color: #fff;"';

                        if (($row->status == 1 && $status->id == 4) ||
                            ($row->status == 2 && in_array($status->id, [1, 2, 3, 4])) ||
                            ($row->status == 3 && in_array($status->id, [1, 2])) ||
                            ($row->status == 4 && in_array($status->id, [1, 2, 3, 4]))) {
                            $disabled = true;
                        }

                        if ($disabled) {
                            $actionBtn .= '<li><a data-id="'.$status->id.'" class="dropdown-item" href="#"' . $disabledStyle . '>' . $status->status_pre . '</a></li>';
                        } else {
                            if($row->status == $status->id){
                                $actionBtn .= '<li><a data-appointment="'.$row->appointment_id.'" data-id="'.$status->id.'" data-name="'.$status->status.'" class="dropdown-item" href="#" style="pointer-events: none; cursor: not-allowed;">' . $status->status_pre . '</a></li>';
                            }else{
                                $actionBtn .= '<li><a id="update_status_btn" data-appointment="'.$row->appointment_id.'" data-id="'.$status->id.'" data-name="'.$status->status.'" class="dropdown-item" href="#">' . $status->status_pre . '</a></li>';
                            }
                        }
                    }

                    $actionBtn .= '
                                </ul>
                            </div>
                            <button class="btn btn-primary" data-id="'.$row->student_id.'" data-bs-toggle="modal" data-bs-target="#student_info_modal" style="color:#fff;"><i class="bi bi-person-fill" style="color: white;"></i></button>
                            <button id="email_appointment" class="btn btn-secondary" data-student="'.$row->student_id.'" data-id="'.$row->appointment_id.'" '.$email_available.'><i class="bi bi-send" style="color: white;"></i></button>
                            <button id="delete_appointment_item" data-id="'.$row->appointment_id.'" class="btn btn-danger"><i class="bi bi-trash" style="color: white;"></i></button>
                        </div>';
                    return $actionBtn;
                })
                ->addColumn('appointment_status', function($row){
                    $status = DB::table('status')->where('id', $row->status)->value('status');
                    if($row->status == 1){
                        $appointment_status = $status;
                    }else if($row->status == 2){
                        $appointment_status = $status;
                    }else if($row->status == 3){
                        $appointment_status = $status;
                    }else if($row->status == 4){
                        $appointment_status = $status;
                    }

                    return $appointment_status;
                })
                ->addColumn('rowClass', function ($row) {
                    if ($row->status == 1) {
                        return 'status-gray';
                    } elseif ($row->status == 2) {
                        return 'status-red';
                    } elseif ($row->status == 3) {
                        return 'status-blue';
                    } elseif ($row->status == 4) {
                        return 'status-green';
                    }
                    return '';
                }) 
                ->addColumn('formatted_appointment_date', function($row){
                    $date = Carbon::parse($row->appointment_date)->format('F j, Y');
                    $time = Carbon::parse($row->appointment_time)->format('g:i a');
                    $from = Carbon::parse($row->appointment_time_from)->format('g:i a');
                    $to = Carbon::parse($row->appointment_time_to)->format('g:i a');
                    $duration = $row->duration;

                    $formatted_appointment_date = '
                        <div>
                            <p><b>' . $date . '</b></p>
                            <p><small>' . $from . ' - ' . $to . '</small> <small>(' . $duration . ' min)</small></p>
                        </div>
                    ';

                    return $formatted_appointment_date;
                })
                ->addColumn('formatted_requested_date', function($row){
                    $date = $row->created_at;

                    $formatted_requested_date = Carbon::parse($date)->format('F j, Y g:i a');

                    return $formatted_requested_date;
                })
                ->addColumn('student_name', function($row){
                    $student = DB::table('students')->where('id', $row->student_id)->first();

                    return ucwords($student->firstname.' '.$student->middlename.' '.$student->lastname.' '.$student->suffix);
                })
                ->rawColumns(['action', 'appointment_status', 'formatted_appointment_date'])
                ->make(true);
        }
    }

    public function fetchSardoRecords(Request $request){
        if ($request->ajax()) {

            $sardo = DB::table('grade_level')->get();

            return DataTables::of($sardo)
                ->addIndexColumn()
                ->addColumn('sardo', function ($row){
                    $no_of_sardo = Drops::leftJoin('students', 'drop_request.student_id', '=', 'students.id')
                                        ->leftJoin('grade_level', 'students.current_grade', '=', 'grade_level.id')
                                        ->where('grade_level.id', $row->id)
                                        ->where('drop_request.status', '=', '1')
                                        ->count();
                    return $no_of_sardo;
                })
                ->rawColumns(['sardo'])
                ->make(true);
        }
    }

    public function fetchModules(Request $request){
        if ($request->ajax()) {

            $modules = DB::table('career_guidance_module')->get();

            return DataTables::of($modules)
                ->addIndexColumn()
                ->addColumn('action', function ($row){
                    $btn = '<button id="view_btn" data-pdf="'.$row->file.'" data-bs-toggle="modal" data-bs-target="#viewPDF" class="btn btn-warning"><i class="bi bi-eye-fill" style="color: white;"></i></button>
                            <button id="delete_btn" data-id="'.$row->id.'" class="btn btn-danger"><i class="bi bi-trash" style="color: white;"></i></button>
                            ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function fetchCounselorList(Request $request){
        if ($request->ajax()) {

            $counselors = DB::table('counselor')->get();

            return DataTables::of($counselors)
                ->addIndexColumn()
                ->addColumn('full_name', function ($row){
                    $full_name = $row->firstname. ' ' . $row->surname;
                    return ucwords($full_name);
                })
                ->rawColumns(['full_name'])
                ->make(true);
        }
    }
}

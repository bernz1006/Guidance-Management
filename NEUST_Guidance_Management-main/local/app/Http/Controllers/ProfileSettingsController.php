<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileSettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware example (optional)
        // $this->middleware(function ($request, $next) {
        //     $response = $next($request);
        //     $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        //     $response->header('Pragma', 'no-cache');
        //     $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        //     return $response;
        // });
    }

    public function profile_editor(Request $request){
        $student_id = DB::table('students')->where('user_id', Auth::user()->id)->value('id');
        $check_email = DB::table('students')->where('id', $student_id)->value('email');

        if($request->file('profile_img') == NULL){
            $studentData = [
                'email' => $request->input('profile_email'),
                'firstname' => $request->input('profile_first_name'),
                'middlename' => $request->input('profile_middle_name'),
                'lastname' => $request->input('profile_last_name'),
                'suffix' => $request->input('profile_suffix'),
                'contact_no' => $request->input('profile_contact'),
                'birthday' => $request->input('profile_birthdate'),
                'sex' => $request->input('profile_gender'),
                'house_no_street' => $request->input('profile_street'),
                'baranggay' => $request->input('profile_baranggay'),
                'municipality' => $request->input('profile_municipality'),
                'province' => $request->input('profile_province'),
                'nationality' => $request->input('profile_nationality'),
                'religion' => $request->input('profile_religion'),
                'father' => $request->input('profile_father'),
                'father_contact' => $request->input('profile_father_contact'),
                'father_occupation' => $request->input('profile_father_occupation'),
                'mother' => $request->input('profile_mother'),
                'mother_contact' => $request->input('profile_mother_contact'),
                'mother_occupation' => $request->input('profile_mother_occupation'),
                'living_with' => $request->input('living_with'),
                'no_of_siblings' => $request->input('profile_no_sibling'),
                'position' => $request->input('profile_sibling_position'),
            ];

            $profile_status = false;
        } else {
            $image = Image::make($request->file('profile_img'))
                        ->resize(800, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->encode('jpg', 75); // Resize and compress image

            $studentData = [
                'student_img' => $image,
                'email' => $request->input('profile_email'),
                'firstname' => $request->input('profile_first_name'),
                'middlename' => $request->input('profile_middle_name'),
                'lastname' => $request->input('profile_last_name'),
                'suffix' => $request->input('profile_suffix'),
                'contact_no' => $request->input('profile_contact'),
                'birthday' => $request->input('profile_birthdate'),
                'sex' => $request->input('profile_gender'),
                'house_no_street' => $request->input('profile_street'),
                'baranggay' => $request->input('profile_baranggay'),
                'municipality' => $request->input('profile_municipality'),
                'province' => $request->input('profile_province'),
                'nationality' => $request->input('profile_nationality'),
                'religion' => $request->input('profile_religion'),
                'father' => $request->input('profile_father'),
                'father_contact' => $request->input('profile_father_contact'),
                'father_occupation' => $request->input('profile_father_occupation'),
                'mother' => $request->input('profile_mother'),
                'mother_contact' => $request->input('profile_mother_contact'),
                'mother_occupation' => $request->input('profile_mother_occupation'),
                'living_with' => $request->input('living_with'),
                'no_of_siblings' => $request->input('profile_no_sibling'),
                'position' => $request->input('profile_sibling_position'),
            ];

            $profile_status = true;
        }

        try {
            $status = DB::table('students')->where('id', $student_id)->update($studentData);
        } catch(Exception $e) {
            return redirect()->back()->with('error_update', 'Profile update failed!');
        }

        if($status || $profile_status){
            if($check_email != $request->input('profile_email')){
                $update_user_email = DB::table('users')->where('id', Auth::user()->id)->update(['email' => $request->input('profile_email')]);

                if(!$update_user_email){
                    return redirect()->back()->with('error_update', 'Profile update failed!');
                }
            }

            DB::table('students')->where('id', $student_id)->update(['updated_at' => now()]);
            return redirect()->back()->with('status_update', 'Profile updated successfully!');
        } else {
            return redirect()->back()->with('status_no_update', 'No changes made.');
        }
    }

    public function profile_editor2(Request $request){
        $student_id = DB::table('students')->where('user_id', Auth::user()->id)->value('id');

        $studentData = [
            'lrn' => $request->input('lrn'),
            'elem_school' => $request->input('elem_school'),
            'gen_average' => $request->input('gen_average'),
            'current_grade' => $request->input('current_grade_options'),
            'current_section' => $request->input('current_section_options'),
            'adviser' => $request->input('adviser')
        ];
        try {

            $status = DB::table('students')->where('id', $student_id)->update($studentData);

        } catch(Exception $e) {

            return redirect()->back()->with('error_update', 'Profile update failed!');

        }

        if($status){

            DB::table('students')->where('id', $student_id)->update(['updated_at' => now()]);
            return redirect()->back()->with('status_update', 'Profile updated successfully!');

        } else {
            return redirect()->back()->with('status_no_update', 'No changes made.');
        }

    }
}

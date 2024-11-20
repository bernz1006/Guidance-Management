<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;

class CounselorListController extends Controller
{
    public function fetchCounselor(Request $request){
        $counselor = DB::table('counselor')->where('id', $request->input('id'))->first();

        return response()->json($counselor);
    }


    public function addCounselor(Request $request){

        // dd($request->all());

        $userData = [
            'email' => $request->input('add_email'),
            'first_name' => $request->input('add_firstname'),
            'last_name' => $request->input('add_surname'),
            'password' => Hash::make($request->input('add_password')),
            'user_type' => 1,
        ];

        try {
            $userId = DB::table('users')->insertGetId($userData);

            $counselorData = [
                'email' => $request->input('add_email'),
                'firstname' => $request->input('add_firstname'),
                'surname' => $request->input('add_surname'),
                'user_id' => $userId,
            ];

            $counselorInserted = DB::table('counselor')->insert($counselorData);

            if ($userId && $counselorInserted) {
                return redirect()->back()->with(['success' => 'Counselor added successfully!'])->withInput();
            } else {
                $errorMsg = 'Error in creation. Please try again or contact support.';
                return redirect()->back()->with(['error' => $errorMsg])->withInput();
            }
        } catch(\Exception $e) {
            $errorMsg = 'Error: ' . $e->getMessage();
            return redirect()->back()->with(['error' => $errorMsg])->withInput();
        }
    }

    public function editCounselor(Request $request){
        $check_email = DB::table('counselor')->where('id', $request->input('counselor_id'))->value('email');
        // dd($request->all());

        $counselorData = [
            'email' => $request->input('email'),
            'firstname' => $request->input('firstname'),
            'surname' => $request->input('surname'),
            'updated_at' => now(),
        ];

        try {
            $status = DB::table('counselor')->where('id', $request->input('counselor_id'))->update($counselorData);

        } catch(\Exception $e) {
            $errorMsg = 'Error: ' . $e->getMessage();
            return redirect()->back()->with(['error' => $errorMsg])->withInput();
        }

        if ($status) {
            if($check_email != $request->input('email')){
                $update_user_email = DB::table('users')->where('id', $request->input('counselor_user_id'))->update(['email' => $request->input('email'), 'updated_at' => now()]);

                if(!$update_user_email){
                    $errorMsg = 'Update error. Please try again or contact support.';
                    return redirect()->back()->with(['error' => $errorMsg])->withInput();
                }
            }

            return redirect()->back()->with(['success' => 'Counselor updated successfully!'])->withInput();
        } else {
            $errorMsg = 'No changes made.';
            return redirect()->back()->with(['error' => $errorMsg])->withInput();
        }
    }

}

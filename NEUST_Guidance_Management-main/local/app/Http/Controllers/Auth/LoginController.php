<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'login_email' => 'required|email',
            'login_password' => 'required'
        ]);

        if (auth()->attempt(array('email' => $input['login_email'], 'password' => $input['login_password']))) {
            session()->flash('login_success', 'Login Successfully ' . auth()->user()->name . '!');

            if (auth()->user()->user_type == 1) {
                return redirect()->route('admin.viewDashboard');
            }else if(auth()->user()->user_type == 2){
                $student = DB::table('students')->where('user_id', auth()->user()->id)->first();

                if($student->student_status == '0'){
                    return redirect()->back()->with(['student_drop_status' => $student->student_status])->WithInput();
                }

                return redirect()->route('user.viewDashboard');
            }
             else {
                abort(404);
            }
        } else {
            $ErrorMsg = 'Invalid Email or Password';
            return redirect()->back()->with(['ErrorMsg' => $ErrorMsg])->WithInput();
        }
    }
}

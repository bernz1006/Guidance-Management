<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'user_type' => 2,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function createStudent(array $data)
    {
        try {
            return Student::create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'user_id' => $data['user_id'],
                'school_id' => $data['school_id'],
            ]);
        } catch (\Exception $e) {
            // Log the error or handle it as per your application's requirements
            dd('Error creating student: ' . $e->getMessage());
            // You can also throw the exception again to propagate it to the caller
        }
    }

    public function register(Request $request)
    {
        // $validatedData = $this->validator($request->all())->validate();

        if(!$this->validator($request->all())->validate()){
            $errorMsg = 'Error in registration. Please try again.';
            return redirect()->back()->with(['errorMsg' => $errorMsg])->withInput();
        }

        $validatedData = $this->validator($request->all())->validate();

        try {
            // Create the user
            $user = $this->create($validatedData);

            $currentDate = Carbon::now();
            $school_id = $currentDate->format('y').'-00'. $user->id;

            $studentData = [
                'firstname' => $request->input('first_name'),
                'lastname' => $request->input('last_name'),
                'email' => $request->input('email'),
                'user_id' => $user->id,
                'school_id' => $school_id,
            ];
            // Create the student
            $student = $this->createStudent($studentData);
            session()->flash('registration_success', 'You have successfully registered! Please log in.');
            // Check if both operations were successful
            if ($user && $student) {

                // If user and student creation are successful, redirect to login
                return redirect()->route('auto_login');

            } else {
                $errorMsg = 'Error in registration. Please try again or contact support.';
                return redirect()->back()->with(['errorMsg' => $errorMsg])->withInput();
            }
        } catch (\Exception $e) {
            // If an error occurs during user or student creation, redirect back with an error message
            $errorMsg = 'Error: ' . $e->getMessage();
            return redirect()->back()->with(['errorMsg' => $errorMsg])->withInput();
        }
    }

}

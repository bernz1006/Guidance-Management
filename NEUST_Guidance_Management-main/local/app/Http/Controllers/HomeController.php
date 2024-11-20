<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirectPage(){
        if(!Auth::check()){
            return redirect()->route('login');
        }else{
            if(Auth::user()->user_type == 1){
                return redirect()->route('admin.viewDashboard');
            }
            if(Auth::user()->user_type == 2){
                return redirect()->route('user.viewDashboard');
            }
        }
    }
}

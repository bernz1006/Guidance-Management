<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class UserAuth
{
    public function handle(Request $request, Closure $next, $userType)
    {
        $user = auth()->user();

        if ($user->user_type == $userType) {
            return $next($request);
        }
        // abort(401);
        return redirect()->back();
    }
}

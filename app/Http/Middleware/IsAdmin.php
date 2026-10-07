<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if the user is authenticated AND has the admin role
        if (Auth::check() && Auth::user()->user_role === 'admin') {
            // Let them proceed to the route
            return $next($request); 
        }

        // 2. If they fail the check, bounce them back to the dashboard
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin area.');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->usertype == 'user') {
                return redirect()->route('home');
            } else if ($user->usertype == 'admin') {
                return redirect()->route('index');
            } else if ($user->usertype == 'superadmin') {
                return redirect()->route('superadmin.index');
            } else {
                // Optional: Handle unknown user types
                return redirect()->route('login')->with('error', 'Unknown user type.');
            }
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }
    }
}